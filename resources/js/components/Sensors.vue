<template>
  <div>
    <dashboarda v-if="this.$store.state.user.type=='admin'"></dashboarda>
    <dashboard v-if="this.$store.state.user.type=='user'"></dashboard>
    <v-data-table :headers="headers" :items="volumes" class="elevation-1">
      <template v-slot:items="props">
        <td>{{ props.item.percipitacao }} %</td>
        <td>{{ props.item.humidade }} %</td>
        <td>{{ props.item.updated_at }}</td>
      </template>
    </v-data-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      headers: [
        { text: "Valores Percipitacao", value: "percipitacao" },
        { text: "Valores Humidade", value: "humidade" },
        { text: "Actualizado", value: "updated_at" }
      ],
      volumes: [],
      items: [
        { title: "Sensors", icon: "assignment", route: { name: "sensors" } }
      ]
    };
  },
  methods: {
    getSensors() {
      axios
        .get("api/getDataSensors")
        .then(response => {
          console.log(response);
          this.volumes = response.data;
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
    this.getSensors();
  }
};
</script>
