<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <div class="card-body">
            <h3 class="mb-3">Company Setup</h3>
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="2" color="#3f51b5" />
            <form @submit.prevent="updateCompanySetup($event)" enctype="multipart/form-data" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Company Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                !isEmpty(errors) && !companyInfo.company_name
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="companyInfo.company_name" placeholder="Company Name" />
                            <p class="text-danger" v-if="
                                errors.company_name.length > 0 && !companyInfo.company_name
                            " v-for="company_name in errors.company_name">
                                {{ company_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="website_slogan">Website Slogan</label>
                            <input type="text" class="form-control" id="website_slogan" v-model="companyInfo.website_slogan">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="website_url">Website URL</label>
                            <input type="text" class="form-control" id="website_url" v-model="companyInfo.website_url">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="contact_phone">Contact Phone <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                !isEmpty(errors) && !companyInfo.contact_phone
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="companyInfo.contact_phone" placeholder="Company Address" />
                            <p class="text-danger" v-if="
                                errors.contact_phone.length > 0 && !companyInfo.contact_phone
                            " v-for="contact_phone in errors.contact_phone">
                                {{ contact_phone }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Contact Email <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                !isEmpty(errors) && !companyInfo.contact_email
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="companyInfo.contact_email" placeholder="Company Address" />
                            <p class="text-danger" v-if="
                                errors.contact_email.length > 0 && !companyInfo.contact_email
                            " v-for="contact_email in errors.contact_email">
                                {{ contact_email }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>District <span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !companyInfo.district
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="companyInfo.district" @change="getThanasByCity($event)">
                                <option value="0">Select District</option>
                                <option v-for="city in cities" :value="city.id" :key="city.id">
                                    {{ city.location }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.district.length > 0 && !companyInfo.district
                            " v-for="district in errors.district">
                                {{ district }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Thana <span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !companyInfo.thana
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="companyInfo.thana">
                                <option value="0">Select Thana</option>
                                <option v-for="thana in thanas" :value="thana.id" :key="thana.id">
                                    {{ thana.name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.thana.length > 0 && !companyInfo.thana
                            " v-for="thana in errors.thana">
                                {{ thana }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Currency <span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !companyInfo.currency
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="companyInfo.currency">
                                <option value="0">Select Currency</option>
                                <option v-for="scurrency in currencies" :value="scurrency.id" :key="scurrency.id">
                                    {{ scurrency.cy_code }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.thana.length > 0 && !companyInfo.thana
                            " v-for="thana in errors.thana">
                                {{ thana }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Theme <span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !companyInfo.theme
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="companyInfo.theme">
                                <option value="0">Select Theme</option>
                                <option v-for="theme in themes" :value="theme.id" :key="theme.id">
                                    {{ theme.theme_name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.theme.length > 0 && !companyInfo.theme
                            " v-for="theme in errors.theme">
                                {{ theme }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Value <span class="text-danger">*</span></label>
                            <input type="color" :class="
                            !isEmpty(errors) && !companyInfo.themecolor
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="companyInfo.themecolor" placeholder="Value" />
                            <p class="text-danger" v-if="
                                errors.themecolor.length > 0 && !companyInfo.themecolor
                            " v-for="themecolor in errors.themecolor">
                                {{ themecolor }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Brand Filtering <span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !companyInfo.brand_filtering
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="companyInfo.brand_filtering">
                                <option value="">Select Filtering</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.brand_filtering.length > 0 && !companyInfo.brand_filtering
                            " v-for="brand_filtering in errors.brand_filtering">
                                {{ brand_filtering }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Color Filtering <span class="text-danger">*</span></label>
                            <select :class="
                                    !isEmpty(errors) && !companyInfo.color_filtering
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " v-model="companyInfo.color_filtering">
                                <option value="">Select Filtering</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.color_filtering.length > 0 && !companyInfo.color_filtering
                            " v-for="color_filtering in errors.color_filtering">
                                {{ color_filtering }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Price Filtering <span class="text-danger">*</span></label>
                            <select :class="
                                    !isEmpty(errors) && !companyInfo.price_filtering
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " v-model="companyInfo.price_filtering">
                                <option value="">Select Filtering</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.price_filtering.length > 0 && !companyInfo.price_filtering
                            " v-for="price_filtering in errors.price_filtering">
                                {{ price_filtering }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label>Company Address <span class="text-danger">*</span></label>
                            <textarea :class="
                                !isEmpty(errors) && !companyInfo.comp_address
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " v-model="companyInfo.comp_address" placeholder="Company Address" rows="3"></textarea>
                            <p class="text-danger" v-if="
                                errors.comp_address.length > 0 && !companyInfo.comp_address
                            " v-for="comp_address in errors.comp_address">
                                {{ comp_address }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Business Type<span class="text-danger">*</span></label>
                            <select class="form-control " v-model="companyInfo.business_type_id">
                                <option value="">Select Type</option>
                                <option v-for="business_type in business_types" :value="business_type.id" :key="business_type.id">
                                    {{ business_type.business_type }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cat_parent_id">Contact Map Location</label>
                            <tinymce id="d1" :other_options="tinyOptions" v-model="companyInfo.contact_map_location"></tinymce>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>Logo (width 250px * height 50px png/jpg)</label>
                        <div class="imageUploadBox">
                            <UploadImages :max="1" @changed="handleLogo" />
                            <div class="previousImg mt-2">
                                <img :src="previous_logo" class="img-thumbnail" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>Favicon (width 50px * hight 50px png/jpg)</label>
                        <div class="imageUploadBox">
                            <UploadImages :max="1" @changed="handleFavicon" />
                            <div class="previousImg mt-2">
                                <img :src="previous_favicon" class="img-thumbnail" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import UploadImages from "vue-upload-drop-images";

export default {
    components: {

        UploadImages,
    },
    data() {
        return {
            companyInfo: {},
            errors: [],
            previous_logo: "",
            previous_favicon: "",
            favicon: null,
            logo: null,
            loading: false,
            cities: [],
            thanas: [],
            currencies: [],
            themes: [],
            business_types: [],
            tinyOptions: {
                'height': 200
            }
        };
    },
    created() {
        this.getCompanyInfo();
        this.getThemes();
        this.getCompanyCities();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        handleLogo(files) {
            this.logo = files[0];
        },
        handleFavicon(files) {
            this.favicon = files[0];
        },
        async getCompanyCities() {
            return await this.$root.getAllData(
                `/api/user/districts/showByCountrys/18`
            );
        },
        async getCompanyThanas() {
            let id = this.companyInfo.district;
            return await this.$root.getAllData(
                `/api/user/thanas/showByDistricts/${id}`
            );
        },
        async getCurrencies() {
            return await this.$root.getAllData(
                `/api/user/currencies`
            );
        },
        async getThemes() {
            return await this.$root.getAllData(
                `/api/user/themes`
            );
        },
        async getBusinessTypes() {
            return await this.$root.getAllData(
                `/api/user/businesstypes`
            );
        },
        getThanasByCity(event) {
            let id = event.target.value;
            this.$root.getAllData(
                `/api/user/thanas/showByDistricts/${id}`
            ).then(res => {
                this.thanas = res;
            })
        },
        async getCompanyInfo() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages(`/api/user/company_setup`);
            this.companyInfo = data[0].data[0];
            this.previous_logo = `${data[0].url}${this.companyInfo.logo}`;
            this.previous_favicon = `${data[0].url}${this.companyInfo.favicon}`;
            Promise.all([
                this.getCompanyCities(),
                this.getCompanyThanas(),
                this.getThemes(),
                this.getCurrencies(),
                this.getBusinessTypes(),

            ]).then((res) => {
                this.cities = res[0];
                this.thanas = res[1];
                this.themes = res[2];
                this.currencies = res[3];
                this.business_types = res[4];
                this.loading = false;
            });
        },
        updateCompanySetup(event) {
            let formData = new FormData();
            formData.append("company_name", this.companyInfo.company_name);
            formData.append("website_slogan", this.companyInfo.website_slogan);
            formData.append("comp_address", this.companyInfo.comp_address);
            formData.append("website_url", this.companyInfo.website_url);
            formData.append("contact_phone", this.companyInfo.contact_phone);
            formData.append("contact_email", this.companyInfo.contact_email);
            formData.append("contact_map_location", this.companyInfo.contact_map_location);
            formData.append("district", this.companyInfo.district);
            formData.append("thana", this.companyInfo.thana);
            formData.append("currency", this.companyInfo.currency);
            formData.append("theme", this.companyInfo.theme);
            formData.append("brand_filtering", this.companyInfo.brand_filtering);
            formData.append("color_filtering", this.companyInfo.color_filtering);
            formData.append("price_filtering", this.companyInfo.price_filtering);
            formData.append("business_type_id", this.companyInfo.business_type_id);
            formData.append("logo", this.logo);
            formData.append("favicon", this.favicon);
            formData.append("themecolor", this.companyInfo.themecolor);

            this.axios
                .post(`${this.$store.state.hostBase}/api/user/company_setup/1?_method=PUT`, formData, {
                    headers: {
                        Authorization: `Bearer ${this.$store.state.token}`,
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    this.$fire({
                        title: res.data.message,
                        type: "success",
                        timer: 2000
                    });
                })
                .catch((err) => {
                    let res = JSON.parse(err.request.response);
                    if (res.status == "error") {
                        this.errors = JSON.parse(err.request.response).validation_errors;
                    } else {
                        this.$fire({
                            title: "Failed to update",
                            type: "warning",
                            timer: 2000
                        });
                    }
                });
        },
    },
};
</script>

<style scoped>
.previousImg {
    max-height: 60px;
}
</style>
