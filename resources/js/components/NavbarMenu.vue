<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" app fixed clipped-right>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div
        class="collapse navbar-collapse"
        id="navbarTogglerDemo01"
        style="display: flex; justify-content: space-around"
      >
        <router-link class="navbar-brand" to="/sensors">SmartFarm</router-link>
        <form class="form-inline my-2 my-lg-0 nav-item">
          <div v-if="user == null">
            <router-link class="btn btn-outline-success my-2 my-sm-0" to="/login">Login</router-link>
          </div>
          <div v-else>
            <button
              class="btn btn-outline-dark my-2 my-sm-0"
              type="submit"
              v-on:click.prevent="logout()"
            >Logout</button>
          </div>
        </form>
      </div>
    </nav>
  </div>
</template>
<script>
export default {
  computed: {
    user: function() {
      return this.$store.state.user;
    }
  },
  data: () => ({}),
  methods: {
    logout() {
      this.$router.push("/login");
      this.$store.commit("clearUserAndToken");
      this.typeofmsg = "alert-success";
      this.message = "User has logged out correctly";
      this.showMessage = true;
    }
  }
};
</script>

<style>
.vs-sidebar {
  max-width: 350px;
}

.header-sidebar {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  width: 100%;
}

h4 {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
}

.footer-sidebar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

.dashboards {
  display: inherit;
}

@media screen and (max-width: 991px) {
  .dashboards {
    display: inline-block;
  }
}
</style>
