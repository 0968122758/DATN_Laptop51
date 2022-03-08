<template>
<div class="container-fluid">
        <div class="row form-create">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row form-create">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">email </label>
                                <input @input="changeInput()"
                                    v-validate="'required|max:255'" type="text" v-model="email" name="email" class="form-control" placeholder="">
                                 <div class="input-group is-danger" role="alert">
                                    {{ errors.first("email") }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">password </label>
                                <input @input="changeInput()"
                                    v-validate="'required|max:255'" type="password" v-model="password" name="password" class="form-control" placeholder="">
                                 <div class="input-group is-danger" role="alert">
                                    {{ errors.first("password") }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">name </label>
                                <input @input="changeInput()"
                                    v-validate="'required|max:255'" type="text" v-model="name" name="name" class="form-control" placeholder="">
                                 <div class="input-group is-danger" role="alert">
                                    {{ errors.first("name") }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">rule </label>
                                <input @input="changeInput()"
                                    v-validate="'required|max:255'" type="number" v-model="rule" name="rule" class="form-control" placeholder="">
                                 <div class="input-group is-danger" role="alert">
                                    {{ errors.first("rule") }}
                                </div>
                            </div>
                        <div class="col-12 d-flex justify-content-end">
                            <br>
                            <a href="" class="btn btn-danger">Hủy</a>
                            &nbsp;
                            <button type="submit" @click.prevent="register" class="btn btn-primary">Lưu</button>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
</div>
</template>
<script>
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
    props: ["createUrl"],
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