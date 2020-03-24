<template>
  <div>
    <!-- Button trigger modal -->
    <button
      type="button"
      class="btn btn-primary btn-sm"
      data-toggle="modal"
      data-target="#modelusers"
      @click="clear"
    >Registrar</button>

    <div
      class="modal fade"
      id="modelusers"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-if="form.id" class="modal-title">Editar usuarios</h5>
            <h5 v-else class="modal-title">Guardar usuarios</h5>
          </div>
          <ValidationObserver v-slot="{ invalid }" ref="form">
            <form method="POST" @submit.prevent="adduser(form.id)" autocomplete="off">
              <div class="modal-body">
                <div class="form-group">
                  <ValidationProvider
                    :rules="{
                        required: true,
                        min: 2,
                        max: 25
                    }"
                    v-slot="{ errors }"
                  >
                    <label for>Nombre</label>
                    <input type="text" class="form-control mb-3" v-model="form.name" name="Nombre" />

                    <span class="badge badge-danger">{{errors[0]}}</span>
                  </ValidationProvider>
                </div>

                <div class="form-group">
                  <ValidationProvider
                    :rules="{
                        required: true,
                        min: 2,
                        max: 30
                    }"
                    v-slot="{ errors }"
                  >
                    <label for>Apellido</label>
                    <input type="text" class="form-control" v-model="form.surname" name="Apellido" />

                    <span class="badge badge-danger">{{errors[0]}}</span>
                  </ValidationProvider>
                </div>
                <div class="form-group">
                  <ValidationProvider :rules="{ required: true }" v-slot="{ errors }">
                    <label for>Email</label>
                    <input type="email" class="form-control" v-model="form.email" name="Email" />
                    <span class="badge badge-danger">{{errors[0]}}</span>
                  </ValidationProvider>
                </div>
                <div class="input-group">
                  <ValidationProvider :rules="{ required: true }" v-slot="{ errors }">
                    <label for>Rol</label>
                    <select class="custom-select" name="rol" id="rol" v-model="form.role_id">
                      <option
                        v-for="(item, index) in roledata"
                        :key="index"
                        v-bind:value="item.id"
                      >{{item.name}}</option>
                    </select>
                    <span class="badge badge-danger">{{errors[0]}}</span>
                  </ValidationProvider>
                </div>
                <div v-if="showpassword"></div>
                <div v-else>
                  <div class="form-group">
                    <ValidationProvider
                      :rules="{
                            required: true,
                            min: 5,
                            max: 10
                        }"
                      v-slot="{ errors }"
                    >
                      <label for>Password</label>
                      <input
                        type="password"
                        class="form-control"
                        v-model="form.password"
                        name="Password"
                      />
                      <span class="badge badge-danger">{{errors[0]}}</span>
                    </ValidationProvider>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" :disabled="invalid" class="btn btn-success btn-sm">
                  <i class="material-icons">check_circle</i>
                </button>
                <button
                  v-show="!form.id"
                  type="button"
                  @click="clear"
                  class="btn btn-warning btn-sm"
                >
                  <i class="material-icons">history</i>
                </button>
                <button
                  v-if="form.id"
                  type="button"
                  @click="password"
                  class="btn btn-danger btn-sm"
                >
                  <i class="material-icons">fingerprint</i>
                </button>
              </div>
            </form>
          </ValidationObserver>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "adduser",
  data() {
    return {
      url: "users",
      showpassword: false,
      roledata: [],
      form: {
        id: null,
        name: null,
        surname: null,
        email: null,
        password: null,
        role_id: 3
      }
    };
  },
  created() {
    this.getRole();
  },
  methods: {
    async adduser(id) {
      if (id) {
        let url = `${this.url}/${id}`;
        try {
          let response = await axios.put(url, this.form);
          this.clear();
          swal(
            "Buen trabajo!",
            `${response.data.user.name} ha sido editado(a)`,
            "success"
          );
          this.$store.dispatch("ListUserA");
          $("#modelusers").modal("hide");
          this.showpassword = false;
        } catch (error) {
          console.log(error.response);
        }
      } else {
        let user = {
          name: this.form.name,
          surname: this.form.surname,
          email: this.form.email,
          role_id: this.form.role_id,
          password: this.form.password
        };
        try {
          let response = await axios.post(this.url, user);
          swal({
            title: "Buen trabajo!",
            text: response.data.message,
            icon: "success"
          });
          this.clear();
          this.$store.dispatch("ListUserA");
          $("#modelusers").modal("hide");
        } catch (error) {
          console.log(error);
        }
      }
    },
    show(row) {
      this.form.id = row.id;
      this.form.name = row.name;
      this.form.surname = row.surname;
      this.form.email = row.email;
      this.form.role_id = row.role_id;
      this.form.password = row.password;
      this.showpassword = true;
      $("#modelusers").modal("show");
    },
    password() {
      this.showpassword = !this.showpassword;
    },
    clear() {
      this.form.id = "";
      this.form.name = "";
      this.form.surname = "";
      this.form.email = "";
      this.form.password = "";
      this.form.role_id = 3;
      this.$refs.form.reset();
    },
    async getRole() {
      let response = await axios.get("roles");
      this.roledata = response.data;
    }
  }
};
</script>
