<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Pack Size" btnRoute="pack_sizes" btnName="Pack Sizes" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updatePackSize($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Pack Weight <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !packsize.packweight
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="packsize.packweight" placeholder="Pack Weight" />
                            <p class="text-danger" v-if="
                                errors.packweight.length > 0 && !packsize.packweight
                            " v-for="packweight in errors.packweight">
                                {{ packweight }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Pack Height <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !packsize.packheight
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="packsize.packheight" placeholder="Pack Weight" />
                            <p class="text-danger" v-if="
                                errors.packheight.length > 0 && !packsize.packheight
                            " v-for="packheight in errors.packheight">
                                {{ packheight }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Pack Width <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !packsize.packwidth
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="packsize.packwidth" placeholder="Pack Width" />
                            <p class="text-danger" v-if="
                                errors.packwidth.length > 0 && !packsize.packwidth
                            " v-for="packwidth in errors.packwidth">
                                {{ packwidth }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Pack Length <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !packsize.packlength
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="packsize.packlength" placeholder="Pack Length" />
                            <p class="text-danger" v-if="
                                errors.packlength.length > 0 && !packsize.packlength
                            " v-for="packlength in errors.packlength">
                                {{ packlength }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Cubic Size <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !packsize.cubicsize
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="packsize.cubicsize" placeholder="Cubic Size" />
                            <p class="text-danger" v-if="
                                errors.cubicsize.length > 0 && !packsize.cubicsize
                            " v-for="cubicsize in errors.cubicsize">
                                {{ cubicsize }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !packsize.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="packsize.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !packsize.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";
export default {
    components: {
        CardHeader,
    },
    data() {
        return {
            errors: [],
            loading: false,
            packsize: {},
        }
    },
    created() {
        this.getPackSize();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        async getPackSize() {
            this.loading = true;
            let data = await this.$root.getAllData(
                `/api/user/packsizes/${this.$route.params.id}`
            );
            this.packsize = data[0];
            this.loading = false;
        },

        updatePackSize(event) {
            this.$root.updateData(this.packsize, `/api/user/packsizes/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "pack_sizes",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                console.dir(res)
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to update",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        }
    }
}
</script>
