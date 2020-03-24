<template>
  <div class="mx-auto" style="width: 300px;">
    <ValidationObserver v-slot="{ invalid }" ref="form">
      <form method="POST" @submit.prevent="Login" autocomplete="off">
        <div class="form-group">
          <ValidationProvider :rules="{ required: true }" v-slot="{ errors }">
            <input
              type="email"
              class="form-control"
              v-model="form.email"
              placeholder="email"
              name="email"
              autofocus
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
        <div class="form-group">
          <ValidationProvider :rules="{ required: true, min: 5, max: 10 }" v-slot="{ errors }">
            <input
              type="password"
              class="form-control"
              v-model="form.password"
              placeholder="password"
              name="password"
            />
            <p class="text-danger">{{ errors[0] }}</p>
          </ValidationProvider>
        </div>
        <button type="submit" :disabled="invalid" class="btn btn-danger btn-sm">Ingresar</button>
      </form>
    </ValidationObserver>
  </div>
</template>
<script>
export default {
  name: "login",
  data() {
    return {
      url: "login",
      form: {
        email: null,
        password: null
      }
    };
  },
  methods: {
    Login() {
      this.$refs.form.validate().then(success => {
        if (!success) {
          return;
        } else {
          axios
            .post(this.url, {
              email: this.form.email,
              password: this.form.password
            })
            .then(response => {
              window.location.replace("/auth/usuarios");
            })
            .catch(error => {
              swal({
                title: "Opps Algo ocurrio!",
                text: "Rectifica las credenciales",
                icon: "warning"
              });
              this.form.password = null;
            });
          this.$nextTick(() => {
            this.$refs.form.reset();
          });
        }
      });
    }
  }
};
</script>