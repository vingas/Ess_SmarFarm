<template>
  <div>
    <dashboarda v-if="this.$store.state.user.type=='admin'"></dashboarda>
    <dashboard v-if="this.$store.state.user.type=='user'"></dashboard>

    <v-container>
      <v-layout>
        <v-chip color="primary" text-color="white">Valor actual : {{this.thresthold}} %</v-chip>
      </v-layout>
      <v-layout>
        <v-flex>
          <v-text-field label="Introduza o valor para iniciar rega" v-model="valorRega"></v-text-field>
          <v-btn color="success" @click="setTreshHold()">Aplicar</v-btn>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      thresthold: "",
      valorRega: "",
      items: [
        { title: "Sensors", icon: "assignment", route: { name: "instance" } },
        { title: "Rega", icon: "invert_colors", route: { name: "rega" } }
      ]
    };
  },
  methods: {
    setTreshHold() {
      let parms = {
        rega: this.valorRega,
        userId: this.$store.state.user.id
      };
      axios
        .post("api/setThreshold", parms)
        .then(response => {
          this.$toasted.success("Valor alterado", {
            duration: 3000,
            position: "top-center",
            theme: "bubble"
          });
          this.getTreshHold();
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
    },
    getTreshHold() {
      axios
        .get("api/getThresholdById/" + this.$store.state.user.id)
        .then(response => {
          this.thresthold = response.data;
        })
        .catch(error => {
          console.log(error);
          console.log(error.response.data.message);
        });
    }
  },
  mounted() {
    this.getTreshHold();
  }
};
</script>
