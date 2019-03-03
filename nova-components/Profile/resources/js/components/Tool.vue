<template>
  <div v-if="!loading && user">
    <div class="profile">
      <heading class="mb-6">Profile</heading>

      <div class="card mb-6 py-3 px-6">
        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">ID</div>
          <div class="w-3/4 py-4">
            <span v-text="user.id"></span>
          </div>
        </div>

        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">Name</div>
          <div class="w-3/4 py-4">
            <span v-text="user.name"></span>
          </div>
        </div>

        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">Email</div>
          <div class="w-3/4 py-4">
            <span v-text="user.email"></span>
          </div>
        </div>

        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">Mobile</div>
          <div class="w-3/4 py-4">
            <span v-text="user.mobile"></span>
          </div>
        </div>

        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">Birthdate</div>
          <div class="w-3/4 py-4">
            <span v-text="user.dob"></span>
          </div>
        </div>

        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">Gender</div>
          <div class="w-3/4 py-4">
            <span v-text="user.gender"></span>
          </div>
        </div>

        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">Avatar</div>
          <div class="w-3/4 py-4" style="max-width: 320px">
            <img :src="`/storage/${user.avatar}`" v-if="user.avatar">
            <span v-if="!user.avatar">___</span>
          </div>
        </div>

        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">Verified</div>
          <div class="w-3/4 py-4">
            <span
              class="inline-block rounded-full w-2 h-2 mr-1"
              :class="[user.status ? 'bg-success': 'bg-danger']"
            ></span>
            <span v-text="user.status ? 'Yes': 'No'"></span>
          </div>
        </div>
      </div>
    </div>

    <div class="merchant" v-if="user.merchant">
      <heading class="mb-6">Merchant</heading>

      <div class="card mb-6 py-3 px-6">
        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">ID</div>
          <div class="w-3/4 py-4">
            <span v-text="user.merchant.id"></span>
          </div>
        </div>

        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">Status</div>
          <div class="w-3/4 py-4">
            <span v-text="user.merchant.status"></span>
          </div>
        </div>

        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">Active</div>
          <div class="w-3/4 py-4">
            <span
              class="inline-block rounded-full w-2 h-2 mr-1"
              :class="[user.merchant.is_active ? 'bg-success': 'bg-danger']"
            ></span>
            <span v-text="user.merchant.is_active ? 'Yes':'No'"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.getAuthUser();
  },

  data() {
    return {
      loading: false,
      user: null
    };
  },

  methods: {
    getAuthUser() {
      this.loading = true;

      Nova.request()
        .post("/nova-vendor/profile/test")
        .then(({ data }) => {
          this.loading = false;
          this.user = data.user;
        })
        .catch(error => {
          this.loading = false;
        });
    }
  }
};
</script>

<style>
/* Scoped Styles */
</style>
