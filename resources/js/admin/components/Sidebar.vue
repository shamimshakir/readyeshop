<template>
    <div>
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-clipboard-outline"></i>
                        <span> Form <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span>
                    </a>
                    <ul class="submenu">
                        <li><router-link to="/customers" class="nav-item nav-link"><i class="mdi mdi-album"></i> Customers</router-link></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-receipt"></i>
                        <span> Reports <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-settings"></i>
                        <span> Basic Setup <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span>
                    </a>
                    <ul class="submenu">
                        <li><router-link to="/social_links" class="nav-item nav-link"><i class="mdi mdi-face-profile"></i> Social Links</router-link></li>
                        <li><router-link to="/colors" class="nav-item nav-link"><i class="mdi mdi-invert-colors"></i> Colors</router-link></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-wrench"></i>
                        <span> Advanced Setup <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</template>

<script>
    export default {
        data() {
            return { }
        },
        created() {
            
        },
        methods: {

        }
    }
</script>
