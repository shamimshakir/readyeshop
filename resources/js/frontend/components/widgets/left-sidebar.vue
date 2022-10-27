<template>
<div id="mySidenav" class="sidenav" :class="{ openSide:leftSidebarVal }">
    <a class="sidebar-overlay" @click="closeLeftBar()"></a>
    <nav>
        <a @click="closeLeftBar()">
            <div class="sidebar-back text-left">
                <i class="fa fa-angle-left pr-2" aria-hidden="true"></i> Back
            </div>
        </a>
        <!-- Sample menu definition -->
        <ul id="sub-menu" class="sidebar-menu">
            <li v-for="category in categories">
                <a href="javascript:void(0)" v-on:click.stop="runRoute(category.cat_name, category.id);">
                    {{ category.cat_name }}
                    <span v-if="category.children_categories.length > 0" class="sub-arrow" v-on:click.stop="setActive(category.cat_name);"></span>
                </a>
                <ul v-if="category.children_categories.length > 0" :class="{ opensub1: isActive(category.cat_name) }">
                    <li v-for="subCatLevelOne in category.children_categories">
                        <a href="javascript:void(0)" v-on:click.stop="runRoute(subCatLevelOne.cat_name, subCatLevelOne.id);">
                            {{ subCatLevelOne.cat_name }}
                            <span v-if="subCatLevelOne.children_categories.length > 0" class="sub-arrow" v-on:click.stop="setActive1(subCatLevelOne.cat_name);"></span>
                        </a>
                        <ul v-if="subCatLevelOne.children_categories.length > 0" :class="{ opensub1: isActive1(subCatLevelOne.cat_name) }">
                            <li v-for="subCatLevelTwo in subCatLevelOne.children_categories">
                                <a href="javascript:void(0)" v-on:click.stop="runRoute(subCatLevelTwo.cat_name, subCatLevelTwo.id);">
                                    {{ subCatLevelTwo.cat_name }}
                                    <span v-if="subCatLevelTwo.children_categories.length > 0" class="sub-arrow" v-on:click.stop="setActive2(subCatLevelTwo.cat_name);"></span>
                                </a>
                                <ul v-if="subCatLevelTwo.children_categories.length > 0" :class="{ opensub1: isActive2(subCatLevelTwo.cat_name) }">
                                    <li v-for="subCatLevelthree in subCatLevelTwo.children_categories">
                                        <a href="javascript:void(0)" v-on:click.stop="runRoute(subCatLevelthree.cat_name, subCatLevelthree.id);">
                                            {{ subCatLevelthree.cat_name }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
</template>

<script>
export default {
    data() {
        return {
            categories: [],
            activeItem: '',
            activeItem1: '',
            activeItem2: '',
        }
    },
    created() {
        this.getCategories();
    },
    computed: {
        leftSidebarVal(){
            return this.$store.state.leftSidebarVal;
        }
    },
    methods: {
        async getCategories() {
            let dataObj = {
                'id': '',
                'level_id': '0',
                'status': '1',
                'parent_id': ''
            };
            let catData = await this.$root.getFrontData(dataObj, '/api/category_param');
            this.categories = catData.data.data;
        },
        closeLeftBar(val) {
            this.$store.commit("CHANGE_LEFT_SIDEBAR", false);
        },
        isActive: function (menuItem) {
            return this.activeItem === menuItem
        },
        setActive: function (menuItem) {
            if (this.activeItem === menuItem) {
                this.activeItem = ''
            } else {
                this.activeItem = menuItem
            }
        },
        setActive1: function (menuItem) {
            if (this.activeItem1 === menuItem) {
                this.activeItem1 = ''
            } else {
                this.activeItem1 = menuItem
            }
        },
        isActive1: function (menuItem) {
            return this.activeItem1 === menuItem
        },
        setActive2: function (menuItem) {
            if (this.activeItem2 === menuItem) {
                this.activeItem2 = ''
            } else {
                this.activeItem2 = menuItem
            }
        },
        isActive2: function (menuItem) {
            return this.activeItem2 === menuItem
        },
        runRoute(category_name, category_id){
            this.$router.push({ name: 'category', query: { catid: category_id }, params: { catname: category_name.replace(/\s+/g, '-').toLowerCase(), catid: category_id } })
        }
    }
}
</script>
