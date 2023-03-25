const login = {
	data: {
		username: "",
		password: "",
	},
	ajax: {
		login: async (data) => {
			let btn = $(".login__submit");
			loading_on(btn);
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("Login/auth"),
				data: data,
				success: (results) => {
					if (results.status) {
						Toast.fire({
							icon: "success",
							title: results.msg,
						}).then(() => {
							location.href = site_url(results.path);
						});
					} else {
						Toast.fire({
							icon: "error",
							title: results.msg,
						}).then(() => {
							$(".login__input").removeClass("invalid");
						});
						$(".login__input").addClass("invalid");
					}
					loading_on_remove(btn);
				},
			});
		},
	},
	async init() {
		let Toast = Swal.mixin({
			toast: true,
			position: "top-end",
			showConfirmButton: false,
			timer: 1500,
			timerProgressBar: true,
			didOpen: (toast) => {
				toast.addEventListener("mouseenter", Swal.stopTimer);
				toast.addEventListener("mouseleave", Swal.resumeTimer);
			},
		});
		$(document).on("click", ".login__submit", (e) => {
			this.data.username = $("input[type='text'].login__input").val();
			this.data.password = $("input[type='password'].login__input").val();
			if (!this.data.username || !this.data.password) {
				Toast.fire({
					icon: "warning",
					title: "โปรดกรอก Username หรือ Password ให้ครบ",
				});
			} else {
				this.ajax.login({
					username: this.data.username,
					password: this.data.password,
				});
			}
		});
	},
};
login.init();
