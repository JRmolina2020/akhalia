<template>
  <div class="mx-auto" style="width: 700px;">
    <div class="mt5">
      <adduser ref="form_user"></adduser>
    </div>
    <div class="row">
      <div class="col-lg-12 mt-5">
        <listuser v-on:show="show"></listuser>
      </div>
    </div>
  </div>
</template>
<script>
import adduser from "./Add";
import listuser from "./List";
export default {
  name: "user",
  components: {
    adduser,
    listuser
  },
  methods: {
    show(row) {
      this.$refs.form_user.show(row);
    }
  }
};
</script>
