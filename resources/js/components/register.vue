<template>
  <div class="container col-lg-4" id="register">
    <form @submit.prevent="submit" class="contact-form">
      <h2>Register User</h2>

      <div class="form-group" :class="{ 'form-group--error': $v.name.$error }">
        <input
          class="form__input form-control"
          required="true"
          placeholder="Name"
          v-model.trim="$v.name.$model"
        >
      </div>

      <div class="form-group" :class="{ 'form-group--error': $v.email.$error }">
        <input
          class="form__input form-control"
          required="true"
          placeholder="Email address"
          v-model.trim="$v.email.$model"
        >
      </div>

      <div class="form-group" :class="{ 'form-group--error': $v.type.$error }">
        <label for="type">Type:</label>
        <select
          class="form-control"
          v-model="type"
          required="true"
          id="type"
          name="type"
          v-model.trim="$v.type.$model"
        >
          <option>admin</option>
          <option>user</option>
        </select>
      </div>

      <div class="form-group">
        <input
          type="password"
          class="form__input form-control"
          v-model="password"
          required="true"
          placeholder="Password"
        >
      </div>

      <button class="btn btn-primary" type="submit" :disabled="submitStatus === 'PENDING'">Save</button>
      <div class="error" v-if="!$v.email.email">Email formart wrong example@example.pt</div>

      <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the field correctly.</p>
      <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>
    </form>
  </div>
</template>

<script>
import { required, email } from "vuelidate/lib/validators";
export default {
  data: function() {
    return {
      submitStatus: null,
      name: "",
      email: "",
      type: "",
      password: ""
    };
  },
  validations: {
    name: {
      required
    },
    email: {
      email,
      required
    },
    type: {
      required
    }
  },
  methods: {
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
          this.registerUser();
        }, 500);
      }
    },
    registerUser: function() {
      let user = {
        name: this.name,
        email: this.email,
        password: this.password,
        type: this.type
      };
      axios
        .post("api/register", user)
        .then(response => {
          this.$router.push({ name: "login" });
          this.$toasted.success("User has been created!", {
            duration: 5000,
            position: "top-center"
          });
        })
        .catch(error => {
          console.log(error);
          console.log(error.response.data.message);
          this.$toasted.error("Something went wrong", {
            duration: 5000,
            position: "top-center"
          });
        });
    }
  }
};
</script>
<style>
#register {
  margin-top: 200px;
}
</style>

