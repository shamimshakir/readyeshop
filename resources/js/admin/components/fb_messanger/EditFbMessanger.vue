<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Messanger Chat" btnRoute="fb_messangers" btnName="Messanger Chat" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateFbMessanger($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>API Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !fb_messanger.name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="fb_messanger.name" placeholder="API Name" />
                            <p class="text-danger" v-if="
                                errors.name.length > 0 && !fb_messanger.name
                            " v-for="name in errors.name">
                                {{ name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !fb_messanger.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="fb_messanger.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !fb_messanger.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>API Code <span class="text-danger">*</span></label>
                            <textarea type="text" rows="12" :class="
                                !isEmpty(errors) && !fb_messanger.status
                                ? 'form-control border-danger'
                                : 'form-control'
                            "  v-model="fb_messanger.command" placeholder="API Code"></textarea>
                            <p class="text-danger" v-if="
                                errors.command.length > 0 && !fb_messanger.command
                            " v-for="command in errors.command">
                                {{ command }}
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
            fb_messanger: {},
        }
    },
    created() {
        this.getFbMessanger();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        async getFbMessanger() {
            this.loading = true;
            let data = await this.$root.getAllData(
                `/api/user/fbmassengers/${this.$route.params.id}`
            );
            this.fb_messanger = data[0];
            this.loading = false;
        },

        updateFbMessanger(event) {
            this.$root.updateData(this.fb_messanger, `/api/user/fbmassengers/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "fb_messangers",
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
