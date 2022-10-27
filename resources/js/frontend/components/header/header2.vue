<template>
	<!-- header start -->
	<header class="header-2">
		<div class="mobile-fix-option"></div>
		<TopBar />
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="main-menu border-section border-top-0">
						<div class="menu-left">
							<div class="navbar">
								<a @click="left_sidebar">
									<i class="fa fa-bars sidebar-bar" aria-hidden="true"></i>
								</a>
								<LeftSidebar/>
							</div>
						</div>
						<div class="brand-logo layout2-logo">
							<router-link :to="{ path: '/' }" exact>
								<img :src="companyimg+companyinfo.logo" class="img-fluid" alt />
							</router-link>
						</div>
						<div class="menu-right pull-right">
							<HeaderWidgets />
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="main-nav-center">
						<Nav :leftSidebarVal="leftSidebarVal" />
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- header end -->
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
		created() {

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
