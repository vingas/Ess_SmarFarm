<template>
  <div id="login" class="container col-lg-4">
    <form @submit.prevent="submit" class="contact-form">
      <h3 class="text-center">Sign in</h3>

      <div class="form-group" :class="{ 'form-group--error': $v.userEmail.$error }">
        <input
          type="text"
          name="email"
          placeholder="Email or Username"
          class="form-control"
          autofocus="true"
          required="true"
          v-model.trim="$v.userEmail.$model"
        >
      </div>

      <div class="form-group" :class="{ 'form-group--error': $v.pass.$error }">
        <input
          type="password"
          name="password"
          placeholder="Password"
          class="form-control"
          required="true"
          v-model.trim="$v.pass.$model"
        >
      </div>
      <button class="btn main-btn" type="submit" :disabled="submitStatus === 'PENDING'">Login</button>

      <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the field correctly.</p>
      <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>
    </form>
  </div>
</template>

<script>
import { required } from "vuelidate/lib/validators";
export default {
  data() {
    return {
      user: {
        email: "",
        password: ""
      },
      submitStatus: null,
      userEmail: "",
      pass: ""
    };
  },
  validations: {
    userEmail: {
      required
    },
    pass: {
      required
    }
  },
  methods: {
    login() {
      this.user.email = this.userEmail;
      this.user.password = this.pass;
      this.showMessage = false;
      axios
        .post("api/login", this.user)
        .then(response => {
          this.$store.commit("setToken", response.data.access_token);
          this.$store.commit("setUser", response.data.user);
          this.typeofmsg = "alert-success";
          this.message = "User authenticated correctly";
          this.showMessage = true;
          switch (response.data.user.type) {
            case "admin":
              this.$router.push("/dashboard");
              break;
            case "user":
              this.$router.push("/dashboardUser");
              break;
          }
        })
        .catch(error => {
          this.$store.commit("clearUserAndToken");
          this.typeofmsg = "alert-danger";
          this.message = "Invalid credentials";
          this.showMessage = true;
          console.log(error);
          this.$toasted.error("Wrong username or password, please try again", {
            duration: 3000,
            position: "top-center",
            theme: "bubble"
          });
        });
    },
    submit() {
      console.log("submit!");
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.submitStatus = "ERROR";
      } else {
        // do your submit logic here
        this.submitStatus = "PENDING";
        setTimeout(() => {
          this.submitStatus = "OK";
          this.login();
        }, 500);
      }
    }
  }
};
</script>

<style>
#login {
  margin-top: 200px;
}

#login h3 {
  padding: 20px;
}
</style>
