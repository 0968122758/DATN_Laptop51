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
                                >Admins Name
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
                                for="text-input"
                                class="col-md-3 col-form-label row-title"
                                >Admins email
                                <span class="u-required">required</span>
                            </label>
                            <div class="col-md-9 row-content">
                                <input
                                    type="text"
                                    class="form-control with-input"
                                    id="email"
                                    name="email"
                                    placeholder="ランニング"
                                    v-model="email"
                                    @input="changeInput()"
                                    v-validate="'required|max:255|email|unique:admins'"
                                />
                                <div class="input-group is-danger" role="alert">
                                    {{ errors.first("email") }}
                                </div>
                                <div
                                    class="input-group is-danger"
                                    v-if="sysErrorsData.email"
                                    role="alert"
                                >
                                    {{ sysErrorsData.name[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row row-container mt-4">
                            <label
                                for="text-input"
                                class="col-md-3 col-form-label row-title"
                                >Admins password
                                <span class="u-required">required</span>
                            </label>
                            <div class="col-md-9 row-content">
                                <input
                                    type="text"
                                    class="form-control with-input"
                                    id="password"
                                    name="password"
                                    placeholder="ランニング"
                                    v-model="password"
                                    @input="changeInput()"
                                    v-validate="'required|max:255'"
                                />
                                <div class="input-group is-danger" role="alert">
                                    {{ errors.first("password") }}
                                </div>
                                <div
                                    class="input-group is-danger"
                                    v-if="sysErrorsData.password"
                                    role="alert"
                                >
                                    {{ sysErrorsData.name[0] }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row row-container mt-4">
                            <label
                                for="text-input"
                                class="col-md-3 col-form-label row-title"
                                >Admins Rule
                                <span class="u-required">required</span>
                            </label>
                            <div class="col-md-9  radio_content">
                                <div class="custom-control custom-radio">
                                <input  type="radio" 
                                        class="custom-control-radio custom-radio" 
                                        id="rule1" 
                                        name="rule"
                                         value="1"
                                    v-model="rule"
                                    @input="changeInput()"
                                    v-validate="'required'"
                                        >
                                <label 
                                 for="defaultGroupExample1">Admin</label>
                                </div>
                                <div class="custom-control custom-radio">
                                 <input  type="radio" 
                                        class="custom-control-radio custom-radio" 
                                        id="rule2" 
                                        name="rule"
                                         value="2"
                                    v-model="rule"
                                    @input="changeInput()"
                                    v-validate="'required'"
                                        >
                                <label 
                                 for="defaultGroupExample1">Supper Admin</label>
                                </div>
                                <div class="input-group is-danger" role="alert">
                                    {{ errors.first("rule") }}
                                </div>
                                <div
                                    class="input-group is-danger"
                                    v-if="sysErrorsData.rule"
                                    role="alert"
                                >
                                    {{ sysErrorsData.name[0] }}
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
import axios from 'axios'

export default {
    data() {
        return {
            email : '',
            name : '',
            password : '',
            rule : '',
            sysErrorsData: {},
            isSubmit: false,
        }
    },
    props: ["createUrl", "checkUniqueUrl"],
    created () {
        let that = this
        this.$validator.extend("unique", {
        validate(value, args) {
            return axios
            .post(that.checkUniqueUrl, {
                _token: Laravel.csrfToken,
                value: value,
                type: args[0],
            })
            .then(function (response) {
                return {
                valid: response.data.valid,
                };
            })
            .catch((error) => {});
        },
        });
    },
    methods: {
        register() {
            let formData = new FormData();
            formData.append("email", this.email);
            formData.append("name", this.name);
            formData.append("password", this.password);
            formData.append("rule", this.rule);
            let that = this;
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
                           this.$swal({
              title: 'Tạo Mới Thành Công',
              icon: "success",
              confirmButtonText: "Okeyyy",
            }).then(function (confirm) {
                  window.location.href = '/admin/admins';
            });
                              
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
    },
}
</script>