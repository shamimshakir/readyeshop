<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit User Guide" btnRoute="user_guides" btnName="User Guides" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateGuide($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="form-group">
                    <label>Question <span class="text-danger">*</span></label>
                    <input type="text" :class="
                            !isEmpty(errors) && !userGuide.question
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="userGuide.question" placeholder="Question" />
                    <p class="text-danger" v-if="
                                errors.question.length > 0 && !userGuide.question
                            " v-for="question in errors.question">
                        {{ question }}
                    </p>
                </div>
                <div class="form-group">
                    <label>Iframe Link</label>
                    <textarea rows="7" :class="
                            !isEmpty(errors) && !userGuide.video
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="userGuide.video" placeholder="Iframe Link">
                    </textarea>
                    <p class="text-danger" v-if="
                                errors.video.length > 0 && !userGuide.video
                            " v-for="video in errors.video">
                        {{ video }}
                    </p>
                </div>
                <div class="form-group">
                    <label>Menu Node <span class="text-danger">*</span></label>
                    <select :class="
                            !isEmpty(errors) && !userGuide.menu_name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="userGuide.menu_name">
                        <option value="">Select a Node</option>
                        <option v-for="node in nodes" :value="node.file_name" :key="node.file_name">
                            {{ node.NodeName }}
                        </option>
                    </select>
                    <p class="text-danger" v-if="
                                errors.menu_name.length > 0 && !userGuide.menu_name
                            " v-for="active_status in errors.menu_name">
                        {{ menu_name }}
                    </p>
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
            userGuide: {},
            nodes: [],
            errors: [],
            loading: false,
        }
    },
    created() {
        this.getUerGuide();
        this.getNodes();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        async getNodes() {
            this.nodes = await this.$root.getAllData("/api/user/treemenu");
        },
        async getUerGuide() {
            this.loading = true;
            let data = await this.$root.getAllData(
                `/api/user/userguides/${this.$route.params.id}`
            );
            this.userGuide = data[0];
            this.loading = false;
        },
        updateGuide(event) {
            this.$root.updateData(this.userGuide, `/api/user/userguides/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "user_guides",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
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
