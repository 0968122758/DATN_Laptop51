<template>
  <div class="container-fluid">
    <div class="row">
      <form>
        <div class="modal-content">
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
                <div class="row w-form-create">
                  <div class="col-6 form-edit">
                    <span class="error fa fa-warning">{{
                      errors.first("email")
                    }}</span>
                    <br />
                    <span v-if="systermError" class="error fa fa-warning">{{
                      systermError.email
                    }}</span>
                    <div class="form-group roww">
                      <div class="label"><label for="">Email </label></div>
                      <input
                        type="text"
                        v-model="email"
                        name="email"
                        class="input form-control"
                        v-validate="`required|email|email_unique:${id}`"
                        placeholder=""
                      />
                    </div>
                    <span class="error fa fa-warning">{{
                      errors.first("name")
                    }}</span>
                    <br />
                    <span v-if="systermError" class="error fa fa-warning">{{
                      systermError.name
                    }}</span>
                    <div class="form-group roww">
                      <div class="label"><label for="">Name </label></div>
                      <input
                        type="text"
                        v-model="name"
                        name="name"
                        class="input form-control"
                        v-validate="'max:255'"
                        placeholder=""
                      />
                    </div>

                    <div class="roww">
                      <div class="label"><label for="">Gender </label></div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          v-model="gender"
                          value="1"
                          type="radio"
                          name="1"
                        />
                        <div><label for="">Male </label></div>
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          v-model="gender"
                          value="2"
                          type="radio"
                          name="2"
                          checked
                        />
                        <div><label for="">Female </label></div>
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          v-model="gender"
                          value="3"
                          type="radio"
                          name="2"
                          checked
                        />
                        <div><label for="">Other </label></div>
                      </div>
                    </div>
                    <span class="error fa fa-warning">{{
                      errors.first("avatar")
                    }}</span>
                    <br />
                    <span v-if="systermError" class="error fa fa-warning">{{
                      systermError.avatar
                    }}</span>
                    <div class="form-group roww">
                      <div class="label"><label for="">Avatar </label></div>
                      <input
                        type="file"
                        v-on:change="onChange"
                        name="avatar"
                        class="input form-control"
                        v-validate=""
                        placeholder=""
                      />
                    </div>
                    <div class="form-group roww">
                      <div class="label"><label for="">Birthdate </label></div>
                      <input
                        type="date"
                        v-model="birthdate"
                        name="birthdate"
                        class="input form-control"
                        v-validate="'required'"
                        placeholder=""
                      />
                    </div>
                    <div class="form-group roww">
                      <div class="label"><label for="">Phone </label></div>
                      <input
                        type="number"
                        v-model="phone"
                        name="phone"
                        class="input form-control"
                        placeholder=""
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" @click.prevent="saveEditUser" class="btn">
              update
            </button>
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
      id: "",
      email: "",
      name: "",
      password: "",
      phone: "",
      birthdate: "",
      avatar: "",
      gender: "",
      systermError: {
        email: "",
        name: "",
        avatar: "",
      },
    };
  },
  props: ["initData"],
  created() {
    this.id = this.initData.user.id;
    this.email = this.initData.user.email;
    this.name = this.initData.user.name;
    this.phone = this.initData.user.phone;
    this.birthdate = this.initData.user.birthdate;
    this.avatar = this.initData.user.avatar;
    this.gender = this.initData.user.gender;
    this.$validator.extend("email_unique", {
      validate(value, args) {
        return axios
          .post("/admin/user/check-unique-email",{
            email: value,
            id: args[0]
          })
          .then(function (response) {
            return response.data.result;
          });
      },
    });
  },
  methods: {
    onChange(e) {
      this.avatar = e.target.files[0];
    },
    saveEditUser() {
      const config = {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      };
      this.$validator.validateAll().then((result) => {
        if (result) {
          let formData = new FormData();
          formData.append("_method", "PUT");
          formData.append("id", this.initData.user.id);
          formData.append("email", this.email);
          formData.append("name", this.name);
          formData.append("birthdate", this.birthdate);
          formData.append("avatar", this.avatar);
          formData.append("gender", this.gender);
          axios
            .post("/admin/user/edit", formData, config)
            .then((response) => {
              this.$swal({
                title: "Update Thành Công !",
                icon: "success",
                confirmButtonText: "Xác nhận",
              }).then(() => {
                window.location.href = `/admin/user`;
              })
            })
            .catch((errors) => {
              this.systermError = errors.response.data.message_validate;
              if (response.status == 500) {
                this.$swal({
                  title: "",
                  icon: "error",
                  confirmButtonText: "はい",
                  customClass: {
                    popup: "popup-alert",
                    icon: "icon-error",
                    title: "title-success title",
                    actions: "actions",
                    confirmButton: "button-success button",
                  },
                });
              }
            });
        }
      });
    },
  },
};
</script>