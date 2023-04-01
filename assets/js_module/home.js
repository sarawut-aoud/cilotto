const home = {
	data: {
		number: "",
	},
	ajax: {
		loaddata: async () => {
			await $.ajax({
				type: "get",
				dataType: "json",
				url: site_url("Dashboard/loaddata"),
				success: (results) => {
					if (results.status) {
						let data = results.data;

						if (data?.json_pay) {
							let content = $(".content .content-pirce");
							let content_p = $(".content-pay");
							let pay = data.json_pay[0];
							let bottom = data.json_bottom[0];
							let top = data.json_top[0];
							content.find(".text").text(pay.name);
							content.find(".price").text(pay.number);
							content_p
								.find(".top-number")
								.text(top.name + " " + top.number + " .-");
							content_p
								.find(".bottom-number")
								.text(bottom.name + " " + bottom.number + " .-");
						}
					}
				},
			});
		},
		getDate: async () => {
			await $.ajax({
				type: "get",
				dataType: "json",
				url: site_url("Dashboard/getDate"),
				success: (results) => {
					if (results.status) {
						let data = results.data;
						data.forEach((e, i) => {
							if (e.is_active == 1) {
								$(".content .content-date .text").text(e.date);
							}
						});
					}
				},
			});
		},
		saveData: async () => {
			await $.ajax({
				type: "POST",
				dataType: "json",
				data: {
					number: $(".content-number .text").text(),
					name: $("#name").val(),
					phone: $("#phone").val(),
					date: $(".content .content-date").text(),
				},
				url: site_url("Dashboard/savedata"),
				success: (results) => {
					if (results.status) {
						Toast.fire({
							icon: "success",
							title: results.msg,
						}).then(async () => {
							home.ajax.get_number();
						});
					} else {
						Toast.fire({
							icon: "error",
							title: results.msg,
						});
					}
				},
			});
		},
		get_number: async () => {
			await $.ajax({
				type: "GET",
				dataType: "json",
				data: {
					date: $(".content .content-date").text(),
				},
				url: site_url("Dashboard/get_number"),
				success: (results) => {
					let item = "";
					if (results.status) {
						let data = results.data;
						data.forEach((ev, i) => {
							let cn = "";
							if (ev.id) {
								cn += "active";
							}
							item += `<div class="box-item btnList ${cn}" data-number="${
								ev.number
							}" data-lotto-id="${ev.id ? ev.id : ""}">
									<div class="box-item-image ">
										<img src="${base_url("assets/images/Sold-Out-PNG.png")}" alt="">
									</div>
									<div class="box-item-tool"></div>
									<div class="box-item-number">${home.methods.setnumber(ev.number)}</div>
								</div>`;
						});
						$(".box-content .box-container").html(item);
					}
				},
			});
		},
		get_numberById: async (id) => {
			await $.ajax({
				type: "POST",
				dataType: "json",
				data: {
					id: id,
				},
				url: site_url("Dashboard/get_numberById"),
				success: (results) => {
					if (results.status) {
						let data = results.data;
						$(".content-number .text").text(data.number);
						$("#name").val(data.fname);
						$("#phone").val(data.phone);
					}
				},
			});
		},
	},
	methods: {
		setnumber: (number) => {
			let data = "";
			if (number < 10) {
				data += "0" + number;
			} else {
				data += number;
			}
			return data;
		},
	},
	async init() {
		let Toast = Swal.mixin({
			toast: true,
			position: "top-end",
			showConfirmButton: false,
			timer: 500,
			timerProgressBar: true,
			didOpen: (toast) => {
				toast.addEventListener("mouseenter", Swal.stopTimer);
				toast.addEventListener("mouseleave", Swal.resumeTimer);
			},
		});
		await this.ajax.loaddata();
		await this.ajax.getDate();
		await this.ajax.get_number();
		$(document).on("click", ` .btnList`, (e) => {
			let obj = $(e.target).closest(` .btnList`);
			$("#name").val("");
			$("#phone").val("");
			if (obj.hasClass("active") === false) {
				let number = obj.data("number");

				$(".content-number .text").text(number);
				this.data.number = number;
			}
			if (
				obj.hasClass("selector") === false &&
				obj.hasClass("active") === false
			) {
				obj.addClass("selector");
				$(` .btnList`).not(obj).removeClass("selector");
			} else {
				obj.removeClass("selector");
				$(".content-number .text").text("N/A");
			}
		});

		$(document).on("click", ` #canceldata`, (e) => {
			$(".content-number .text").text("N/A");
			this.data.number = "";
		});
		$(document).on("click", "#savedata", (e) => {
			this.ajax.saveData();
		});
		$(document).on("click", ".box-item-image", async (e) => {
			let obj = $(e.target).closest(".btnList");
			let id = obj.data("lotto-id");
			await this.ajax.get_numberById(id);
		});
	},
};
home.init();
