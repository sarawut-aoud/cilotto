const main = {
	data: {
		number: "",
		dataTable: null,
		dateDate: [],
		datareport: [],
		table: null,
	},
	methods: {
		table: (data) => {
			let item = "";
			let action = "";

			for (let i in data) {
				if (data[i].is_active == 0) {
					action = ":p";
				} else {
					action = "1";
				}
				item += `
            <tr>
                <td>${data[i].date}</td>
                <td>${action}</td>
            </tr>
        `;
			}
			$("#contentdate").html(item);
		},
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
						let json_pay = data.json_pay[0];
						let json_bottom = data.json_bottom[0];
						let json_top = data.json_top[0];
						if (json_pay) {
							$("#pay_name").val(json_pay.name);
							$("#pay_number").val(json_pay.number);
						}
						if (json_bottom) {
							$("#bottom_name").val(json_bottom.name);
							$("#bottom_number").val(json_bottom.number);
						}
						if (json_top) {
							$("#top_name").val(json_top.name);
							$("#top_number").val(json_top.number);
						}
					}
				},
			});
		},
		save_jsonpay: async (modules) => {
			let json = "";

			if (modules == "pay") {
				json = [
					{
						name: $("#pay_name").val() ? $("#pay_name").val() : "เบอร์ละ",
						number: $("#pay_number").val() ? $("#pay_number").val() : "50",
					},
				];
			} else if (modules == "top") {
				json = [
					{
						name: $("#top_name").val() ? $("#top_name").val() : "ถูกบน",
						number: $("#top_number").val() ? $("#top_number").val() : "300",
					},
				];
			} else if (modules == "bottom") {
				json = [
					{
						name: $("#bottom_name").val() ? $("#bottom_name").val() : "ถูกล่าง",
						number: $("#bottom_number").val()
							? $("#bottom_number").val()
							: "3000",
					},
				];
			}

			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("Dashboard/save"),
				data: {
					function: modules,
					data: json,
				},
				success: (results) => {
					if (results.status) {
						Swal.fire({
							icon: "success",
							title: "บันทึกสำเร็จ",
							showConfirmButton: false,
							timer: 1500,
						}).then(() => {
							main.ajax.loaddata();
						});
					} else {
						Swal.fire({
							icon: "error",
							title: results.data,
							showConfirmButton: false,
							timer: 1500,
						});
					}
				},
			});
		},
		savedate: async () => {
			let date = $("#date_number");

			if (!date.val()) {
				Swal.fire({
					icon: "warning",
					title: "โปรดเลือกวันที่",
					showConfirmButton: false,
					timer: 1500,
				});
			} else {
				await $.ajax({
					type: "POST",
					dataType: "json",
					url: site_url("Dashboard/savedate"),
					data: {
						function: "date",
						date: date.val(),
					},
					success: (results) => {
						if (results.status) {
							Swal.fire({
								icon: "success",
								title: "บันทึกสำเร็จ",
								showConfirmButton: false,
								timer: 1500,
							}).then(async () => {
								main.methods.setdata();
							});
						} else {
							Swal.fire({
								icon: "error",
								title: "เกิดข้อผิดพลาด",
								showConfirmButton: false,
								timer: 1500,
							});
						}
					},
				});
			}
		},
		get_date: async () => {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("Dashboard/getDate"),
				data: {
					function: "getdate",
				},
				success: (results) => {
					let item = "<option value selected>เลือกวันที่</option>";
					if (results.data.length > 0) {
						let data = results.data;

						main.data.dateDate = results.data;
						data.forEach((el, index) => {
							item += `<option value="${el.date}" >${el.date}</option>`;
						});
					}
					$("#date-select").html(item);
				},
			});
		},
		setdate: async (id) => {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("Dashboard/setdate"),
				data: {
					dateid: id,
				},
				success: (results) => {
					if (results.status) {
						Toast.fire({
							icon: "success",
							title: results.msg,
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
		get_dataTable: async (date) => {
			await $.ajax({
				type: "post",
				dataType: "json",
				data: {
					date: date,
				},
				url: site_url("Dashboard/get_report"),
				success: (results) => {
					main.data.datareport = [];
					if (results.status) {
						main.data.datareport = results.data;
					}
				},
			});
		},
	},
	methods: {
		setTable: async (data) => {
			data.forEach((ev, i) => {
				main.data.table.row
					.add([ev.date, main.methods.options(ev)])
					.draw(false);
			});
		},
		setTablereport: async (data) => {
			if (data.length > 0) {
				data.forEach((ev, i) => {
					main.data.dataTable.row
						.add([ev.fname, ev.number, ev.lot_date])
						.draw(false);
				});
			}
		},
		hidden: (data) => {
			return `<div class="hidden-tr">${data}</div>`;
		},
		options: (data) => {
			let action = "";
			if (data.is_active == 0) {
				action = `<div class="setdate checkdate btn-setdate" data-id="${data.id}">
							<div class="setdate-item">
								<div class="icon"><i class="fa-regular fa-circle-check"></i></div>
							</div>
                    	
                  </div>`;
			} else {
				action = `<div class="setdate checkdate btn-setdate" data-id="${data.id}">
							<div class="setdate-item active">
								<div class="icon"><i class="fa-solid fa-circle-check"></i></div>
							</div>
                		</div>`;
			}
			return action;
		},
		setdata: async () => {
			main.data.dataTable.clear().draw();
			main.data.table.clear().draw();
			await main.ajax.get_date();
			await main.ajax.loaddata();
			await main.methods.setTable(main.data.dateDate);
			await main.ajax.get_dataTable("");
			await main.methods.setTablereport(main.data.datareport);
		},
	},
	async init() {
		this.data.table = $("#tabledate").DataTable({
			responsive: true,
			autoWidth: true,
		});
		this.data.dataTable = $("#datatable").DataTable({
			responsive: true,
			autoWidth: true,
			dom: "Bfrtip",
			buttons: ["copy", "excel", "pdf"],
		});
		this.data.dataTable
			.buttons()
			.container()
			.appendTo($(".col-sm-6:eq(0)", this.data.dataTable.table().container()));
		// this.data.dataTable =
		await this.ajax.get_date();
		await this.ajax.loaddata();
		await this.methods.setTable(this.data.dateDate);

		await this.ajax.get_dataTable("");
		await this.methods.setTablereport(this.data.datareport);

		$(document).on("click", ".save-data", (e) => {
			let obj = $(e.target).closest(".save-data");
			let attr = obj.attr("data-module");
			this.ajax.save_jsonpay(attr);
		});
		$(document).on("click", ".save-data-date", (e) => {
			this.ajax.savedate();
		});
		$(document).on("click", ".setdate ", (e) => {
			let obj = $(e.target).closest(".setdate");
			let id = obj.data("id");
			let item = obj.find(".setdate-item");
			$(".setdate-item").not(obj).removeClass("active");
			$(".setdate-item")
				.not(obj)
				.find(".icon")
				.html('<i class="fa-regular fa-circle-check"></i>');

			if (item.hasClass("active")) {
				item.removeClass("active");
				item.find(".icon").html('<i class="fa-regular fa-circle-check"></i>');
			} else {
				item.addClass("active");
				item.find(".icon").html('<i class="fa-solid fa-circle-check"></i>');
			}
			this.ajax.setdate(id);
		});

		$(document).on("change", "#date-select", async (e) => {
			let date = $(e.target).val();
			this.data.dataTable.clear().draw();
			await this.ajax.get_dataTable(date);
			await this.methods.setTablereport(main.data.datareport);
		});
	},
};

$(document).ready(function () {
	main.init();
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
	$(".datatable")
		.DataTable({
			responsive: true,
			lengthChange: false,
			autoWidth: false,
			buttons: ["excel", "pdf", "print", "colvis"],
		})
		.buttons()
		.container()
		.appendTo("#datatable_wrapper .col-md-6:eq(0)");
});
