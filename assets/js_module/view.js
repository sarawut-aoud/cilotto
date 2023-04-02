const view = {
	ajax: {
		loaddata: async () => {
			await $.ajax({
				type: "get",
				dataType: "json",

				url: site_url("View/loaddata"),
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
				url: site_url("View/getDate"),
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
		get_number: async () => {
			await $.ajax({
				type: "GET",
				dataType: "json",
				data: {
					date: $(".content .content-date .text").text(),
				},
				url: site_url("View/get_number"),
				success: (results) => {
					console.log(results);
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
									<div class="box-item-number">${view.methods.setnumber(ev.number)}</div>
								</div>`;
						});
						$(".box-content .box-container").html(item);
					}
				},
			});
		},
		getDate: async () => {
			await $.ajax({
				type: "get",
				dataType: "json",
				url: site_url("View/getDate"),
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
		await this.ajax.loaddata();
		await this.ajax.getDate();
		await this.ajax.get_number();
	},
};
view.init();
