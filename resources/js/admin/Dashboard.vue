<template>
	<div v-if="isAuthenticated">
		<div class="fullscreen-wrapper">
			<div :class="enlargePage ? 'topbar enlarged' : 'topbar' ">
				<div class="topbarshopname">{{ shopName }}</div>
				<nav class="navbar-custom">
					<ul class="navbar-right d-flex list-inline float-right mb-0">
						<li class="dropdown notification-list">
							<a href="#" role="button" class="nav-link header-item noti-icon waves-effect"
								data-toggle="fullscreen" @click="toggle">
								<i class="mdi mdi-fullscreen font-size-24"></i>
							</a>
						</li>
						<li class="dropdown notification-list">
							<a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
								role="button" aria-haspopup="false" aria-expanded="false">
								<i class="fas fa-bell"></i>
								<span class="badge badge-pill badge-danger noti-icon-badge">3</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
								<!-- item-->
								<h6 class="dropdown-item-text">
									Notifications (258)
								</h6>
								<div class="slimscroll notification-item-list">
									<!-- item-->
									<a href="javascript:void(0);" class="dropdown-item notify-item">
										<div class="notify-icon bg-primary"><i class="mdi mdi-cart-outline"></i></div>
										<p class="notify-details">Your order is placed<span class="text-muted">Dummy
												text of the printing and typesetting industry.</span></p>
									</a>
									<!-- item-->
									<a href="javascript:void(0);" class="dropdown-item notify-item">
										<div class="notify-icon bg-danger"><i class="mdi mdi-message"></i></div>
										<p class="notify-details">New Message received<span class="text-muted">You have
												87 unread messages</span></p>
									</a>
								</div>
								<!-- All-->
								<a href="javascript:void(0);" class="dropdown-item text-center text-primary">
									View all <i class="fi-arrow-right"></i>
								</a>
							</div>
						</li>
						<li class="dropdown notification-list">
							<div class="dropdown notification-list nav-pro-img">
								<a class=" dropdown-toggle nav-link arrow-none waves-effect nav-user"
									data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
									aria-expanded="false">
									{{ loggedUserName }} <i class="fas fa-user"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right profile-dropdown">
									<router-link to="/profile" class="dropdown-item">
										Profile
									</router-link>
									<router-link to="/change-password" class="dropdown-item">
										Password Password
									</router-link>
									<button class="dropdown-item text-danger" v-on:click="logout">
										<i class="mdi mdi-power text-danger"></i> Logout
									</button>
								</div>
							</div>
						</li>
					</ul>
				</nav>
			</div>

			<div :class="enlargePage ? 'content-page enlarged' : 'content-page' ">
				<sidebar-menu :menu="navMenus" width="240px" :showOneChild="true" @toggle-collapse="onToggleCollapse">
					<template v-slot:header>
						<router-link to="/">
							<img style="width: 200px; height: auto; margin: 15px;"
								src="https://readyeshop.com/images/logo.png" alt="" />
						</router-link>
					</template>
				</sidebar-menu>
				<div class="content">
					<vue-page-transition name="fade-in-left">
						<router-view name="dashboard" />
					</vue-page-transition>
				</div>
			</div>

		</div>
	</div>
</template>

<script>
	import {
		api as fullscreen
	} from 'vue-fullscreen';
	export default {
		data() {
			return {
				isAuthenticated: false,
				fullscreen: false,
				teleport: true,
				menuLiat: [],
				navMenus: [],
				enlargePage: false,
				shopName: "",
				loggedUserName: "",
			};
		},
		created() {
			this.getMenulist();
			this.getUserName();
			this.getCompanyInfo();
			if (this.$store.state.token) {
				this.isAuthenticated = true;
			} else {
				this.$router.push("/login").catch(() => {});
			}
		},
		methods: {
			onToggleCollapse(collapsed) {
				if (collapsed) {
					this.enlargePage = true;
				} else {
					this.enlargePage = false;
				}
			},
			logout() {
				sessionStorage.removeItem("loginInfo");
				this.$store.commit("UPDATE_TOKEN_FROM_LOGIN", null);
				this.isAuthenticated = false;
				this.$router.push("/login").catch(() => {});
			},
			toggle() {
				fullscreen.toggle(this.$el.querySelector('.fullscreen-wrapper'), {
					teleport: this.teleport,
					callback: (isFullscreen) => {
						this.fullscreen = isFullscreen
					},
				})
			},
			async getUserName() {
				let data = await this.$root.getAllData('/api/user');
				this.loggedUserName = data.first_name;
			},
			async getCompanyInfo() {
				let data = await this.$root.getAllDataWithImages(`/api/user/company_setup`);
				this.shopName = data[0].data[0].company_name;
			},
			async getMenulist() {
				this.menuLiat = await this.$root.getAllData('/api/user/buildmenu');
				this.navMenus = this.menuLiat.map(pMenu => {
					let menuObj = {};
					menuObj.title = pMenu.NodeName;
					menuObj.icon = pMenu.icon;
					menuObj.child = pMenu.children.map(chMenu => {
						return {
							href: chMenu.route_location,
							title: chMenu.NodeName,
							icon: chMenu.icon,
							hidden: chMenu.view_status != 1 ? true : false,
						}
					})
					return menuObj;
				})
			},
		},
	};
</script>

<style>
	li.dropdown.notification-list>i {
		font-size: 20px !important;
	}

	.vsm--scroll-wrapper::-webkit-scrollbar {
		display: none !important;
	}

	.vsm--scroll-wrapper {
		-ms-overflow-style: none !important;
		scrollbar-width: none !important;
	}

	.v-sidebar-menu {
		background-color: #003541 !important;
	}

	.v-sidebar-menu .vsm--link_level-1 .vsm--icon {
		background-color: #003541 !important;
	}

	.v-sidebar-menu .vsm--toggle-btn {
		background-color: #003541 !important;
	}

	.v-sidebar-menu .vsm--dropdown .vsm--list {
		background-color: #032830 !important;
	}

	.v-sidebar-menu .vsm--link {
		padding: 6px 14px !important;
	}

	.v-sidebar-menu .vsm--title {
		font-size: 13px !important;
		color: #fbfbfbbf;
	}

	.v-sidebar-menu.vsm_collapsed>a {
		display: none;
	}

	.content-page {
		transition: .3s;
	}

	.content-page.enlarged {
		margin-left: 37px !important;
	}

	.v-sidebar-menu .vsm--icon {
		color: #fbfbfbbf !important;
	}

	.v-sidebar-menu .vsm--arrow {
		color: #fbfbfbbf;
	}

	.v-sidebar-menu .vsm--item .active.vsm--link_exact-active .vsm--title,
	.v-sidebar-menu .vsm--item .active.vsm--link_exact-active .vsm--icon,
	.v-sidebar-menu .vsm--item.vsm--item_open>a span,
	.v-sidebar-menu .vsm--item.vsm--item_open a.vsm--link.vsm--link_level-1.vsm--link_active i,
	.v-sidebar-menu .vsm--item.vsm--item_open a.vsm--link.vsm--link_level-1.vsm--link_active .vsm--arrow.vsm--arrow_open {
		color: #fff !important;
	}

	.topbarshopname {
		float: left;
		margin-left: 275px;
		font-size: 25px;
		font-weight: 500;
		margin-top: 15px;
		color: #dc3545;
		transition: .3s;
	}

	.enlarged .topbarshopname {
		margin-left: 68px;
		transition: .3s;
	}
</style>
