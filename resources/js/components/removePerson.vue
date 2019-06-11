<<template>
    <div>
         <v-select
          v-model="e1"
          :items="items"
          menu-props="auto"
          label="Select a User"
          hide-details
          single-line
        ></v-select>
    </div>
</template>
<script>
export default {
  data() {
    return {
      e1: "",
      items: []
    };
  },
  methods: {
    getUsers() {
      console.log("passei aqui");
      axios
        .get("api/getUsers")
        .then(response => {
          console.log(response.data);
          this.items = response.data;
        })
        .catch(error => {
          console.log(error);
          console.log(error.response.data.message);
          this.$toasted.error(error.response.data.message, {
            duration: 3000,
            position: "top-center",
            theme: "bubble"
          });
        });
    }
  },
  mounted() {
    this.getUsers();
  }
};
</script>
