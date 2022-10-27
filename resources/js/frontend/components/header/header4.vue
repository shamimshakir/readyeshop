<template>
	<div>
		<header>
			<div class="mobile-fix-option"></div>
			<TopBar />
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="main-menu">
							<div class="menu-left category-nav-right">
								<div class="brand-logo">
									<router-link :to="{ path: '/' }" exact>
										<img :src="companyimg+companyinfo.logo" class="img-fluid" alt />
									</router-link>
								</div>
								<div class="navbar">
									<a @click="left_sidebar">
										<div class="bar-style">
											<i class="fa fa-bars sidebar-bar" aria-hidden="true"></i>
										</div>
									</a>
									<LeftSidebar />
								</div>
							</div>
							<div class="menu-right pull-right">
								<Nav />
								<HeaderWidgets />
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
	</div>
</template>
<script>
	import TopBar from '../widgets/topbar'
	import LeftSidebar from '../widgets/left-sidebar'
	import Nav from '../widgets/navbar'
	import HeaderWidgets from '../widgets/header-widgets'
	export default {
		data() {
			return {
				leftSidebarVal: false
			}
		},
		components: {
			TopBar,
			LeftSidebar,
			Nav,
			HeaderWidgets
		},
		computed: {
			companyinfo() {
				return this.$store.state.companyInfo;
			},
			companyimg() {
				return this.$store.getters.companyImg;
			},
		},
		methods: {
			left_sidebar() {
				this.$store.commit("CHANGE_LEFT_SIDEBAR", true);
			},
		}
	}
</script>
