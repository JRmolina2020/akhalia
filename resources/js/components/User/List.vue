<template>
  <div v-if="status">
    <div class="mt-5" v-if="users.length == 0">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>No existen Registros</strong> de usuarios
      </div>
    </div>
    <div v-else>
      <label for>Buscar Usuario</label>
      <input class="form-control" v-model="filters.data.value" />
      <div class="table-responsive mt-5">
        <v-table
          :data="users"
          :currentPage.sync="currentPage"
          :filters="filters"
          :pageSize="3"
          @totalPagesChanged="totalPages = $event"
          class="table table-borderles table-dark table-striped"
        >
          >
          <thead slot="head">
            <tr>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Correo</th>
              <th>Rol</th>
              <th>Estado</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody slot="body" slot-scope="{ displayData }">
            <tr v-for="row in displayData" :key="row.id">
              <td>{{ row.name }}</td>
              <td>{{ row.surname }}</td>
              <td>{{ row.email }}</td>
              <td>{{row.role}}</td>
              <td>
                <button
                  v-if="row.status"
                  @click="isactive(row)"
                  type="button"
                  class="btn btn-success btn-sm"
                >
                  <i class="material-icons md-18">power_settings_new</i>
                </button>
                <button v-else @click="isactive(row)" type="button" class="btn btn-danger btn-sm">
                  <i class="material-icons md-18">highlight_off</i>
                </button>
              </td>
              <td>
                <button @click="$emit('show', row)" type="button" class="btn btn-warning btn-sm">
                  <i class="material-icons md-18">create</i>
                </button>
                <button @click="remove(row)" type="button" class="btn btn-danger btn-sm">
                  <i class="material-icons md-18">delete</i>
                </button>
              </td>
            </tr>
          </tbody>
        </v-table>
      </div>
      <center>
        <smart-pagination :currentPage.sync="currentPage" :totalPages="totalPages" />
      </center>
      {{ number }}
    </div>
  </div>
  <div v-else>
    <div class="d-flex justify-content-center">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState, mapMutations, mapActions } from "vuex";
export default {
  name: "listuser",
  props: ["number"],
  data() {
    return {
      filters: {
        data: { value: "", keys: ["name", "surname", "email", "role"] }
      },
      currentPage: 1,
      totalPages: 0
    };
  },
  computed: {
    ...mapState(["users", "userslocked", "status"])
  },
  created() {
    this.getusers();
  },
  methods: {
    getusers() {
      this.$store.dispatch("ListUserA");
    },
    async destroy(row) {
      let url = "users/" + row.id;
      let response = await axios.delete(url);
      try {
        swal({
          title: "Buen trabajo!",
          text: `El usuario ${row.name} ${response.data.message}`,
          icon: "success"
        });
        this.getusers();
      } catch (error) {
        console.log(error);
      }
    },
    async remove(row) {
      let url = "users/" + row.id;
      let response = await axios.delete(url);
      this.getusers();
    },
    async isactive(row) {
      if (row.status == 1) {
        let url = "users/locked/" + row.id;
        let response = await axios.put(url);
      } else {
        let url = "users/available/" + row.id;
        let response = await axios.put(url);
      }
      this.getusers();
    }
  }
};
</script>
<style >
.material-icons.md-18 {
  font-size: 18px;
}
</style>