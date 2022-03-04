<template>
    <div class="form-box-container">
        <div class="fade-in">
            <form
                @submit.prevent="register"
                method="POST"
                class="form-horizontal"
                action=""
            >
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row row-container mt-4">
                            <label
                                for="text-input"
                                class="col-md-3 col-form-label row-title"
                                >Category Name
                                <span class="u-required">required</span>
                            </label>
                            <div class="col-md-9 row-content">
                                <input
                                    type="text"
                                    class="form-control with-input"
                                    id="name"
                                    name="name"
                                    placeholder="ランニング"
                                    v-model="name"
                                    @input="changeInput()"
                                    v-validate="'required|max:255'"
                                />
                                <div class="input-group is-danger" role="alert">
                                    {{ errors.first("name") }}
                                </div>
                                <div
                                    class="input-group is-danger"
                                    v-if="sysErrorsData.name"
                                    role="alert"
                                >
                                    {{ sysErrorsData.name[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row row-container mt-4">
                            <label
                                class="col-md-3 col-form-label row-title"
                                for="text-input"
                                >Overview</label
                            >
                            <div class="col-md-9 row-content">
                                <textarea
                                    class="form-control with-input"
                                    id="overview"
                                    name="overview"
                                    rows="2"
                                    v-model="overview"
                                    v-validate="'max:255'"
                                    @input="changeInput()"
                                />
                                <div class="input-group is-danger" role="alert">
                                    {{ errors.first("overview") }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row row-container mt-4">
                            <label
                                class="col-md-3 col-form-label row-title title-image"
                                for="text-input"
                                >Icon</label
                            >
                            <div class="col-md-9 px-0">
                                <div class="position-relative d-inline-block">
                                    <label for="file_icon">
                                        <div class="category-file-image">
                                            <img
                                                v-if="previewImg"
                                                :src="previewImg"
                                                ref="imageDispaly"
                                                class="img-thumbnail"
                                            />
                                            <svg
                                                v-if="!previewImg"
                                                width="94"
                                                height="94"
                                                viewBox="0 0 50 50"
                                                class="text-left"
                                                ref="iconFile"
                                            >
                                                <use
                                                    xlink:href="/images/Group_1287.svg#Group_1287"
                                                ></use>
                                            </svg>
                                        </div>
                                        <input
                                            type="file"
                                            id="file_icon"
                                            name="flieImage"
                                            ref="image"
                                            v-on:change="attachImage"
                                            accept="image/*"
                                            class="hidden"
                                        />
                                    </label>
                                </div>
                                <div class="input-group is-danger" role="alert">
                                    {{ errors.first("icon") }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button-register text-center">
                    <button
                        type="submit"
                        class="btn btn-success hiragino-sans-w7"
                        :disabled="isSubmit"
                    >
                        登録
                    </button>
                </div>
            </form>
        </div>
        <div class="loader-container" v-if="isSubmit">
            <div class="loader"></div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    created: function () {},
    data() {
        return {
            data: {},
            name: "",
            overview: "",
            icon: "",
            previewImg: null,
            sysErrorsData: {},
            isSubmit: false,
        };
    },
    props: ["createUrl"],
    methods: {
        register() {
            let formData = new FormData();
            formData.append("name", this.name);
            formData.append("overview", this.overview);
            formData.append("icon", this.icon);
            this.$validator.validateAll().then((valid) => {
                if (valid) {
                    this.isSubmit = true;
                    axios
                        .post(this.createUrl, formData, {
                            header: {
                                "Content-Type": "multipart/form-data",
                            },
                        })
                        .then((res) => {
                            window.location.href = "/admin/category";
                        })
                        .catch((err) => {
                            this.isSubmit = false;
                            switch (err.response.status) {
                                case 400:
                                    this.sysErrorsData = err.response.data;
                                    break;
                                default:
                                    break;
                            }
                        });
                }
            });
        },
        changeInput() {
            this.sysErrorsData = [];
        },
        attachImage(e) {
            const file = e.target.files[0];
            if (file == undefined) return;
            this.icon = file;
            const imagePreviewUrl = URL.createObjectURL(file);
            this.previewImg = imagePreviewUrl;
        },
    },
};
</script>
