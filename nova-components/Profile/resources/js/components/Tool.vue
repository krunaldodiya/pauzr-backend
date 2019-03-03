<template>
  <div>
    <heading class="mb-6">Profile</heading>

    <button @click="hello()">click me</button>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log(this.data);
  },

  methods: {
    hello() {
      Nova.request()
        .post("/nova-vendor/profile/test")
        .then(({ data }) => {
          console.log(data);
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>

<style>
/* Scoped Styles */
</style>
