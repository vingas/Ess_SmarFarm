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
    <div>
      <select class="form-control" v-model="type" required="true" id="type" name="type">
        <option>Sensor de humidade</option>
        <option>Sensor de percipitacao</option>
      </select>
      <button class="btn btn-info" v-on:click.prevent="getStats()">Selecionar estatisticas</button>
      <line-chart v-if="data" :chart-data="data"></line-chart>
    </div>
  </div>
</template>


<script>
import LineChart from "./lineChart.js";
import { log } from "util";

export default {
  components: {
    LineChart
  },
  data() {
    return {
      data: null,
      type: "",
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
          this.volumes = response.data;
          this.dataSensors = response.data;
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
    getStats() {
      if (this.type == "Sensor de humidade") {
        axios
          .get("api/getDataSensorsStats/" + this.type)
          .then(response => {
            this.data = {
              labels: response.data[1],
              datasets: [
                {
                  label: "Dados do sensor de Humidade",
                  backgroundColor: "#58FAD0",
                  data: response.data[0]
                }
              ]
            };
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
      if (this.type == "Sensor de percipitacao") {
        axios
          .get("api/getDataSensorsStats/" + this.type)
          .then(response => {
            this.data = {
              labels: response.data[1],
              datasets: [
                {
                  label: "Dados do sensor de percipitacao",
                  backgroundColor: "#084B8A",
                  data: response.data[0]
                }
              ]
            };
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
    }
  },
  mounted() {
    this.getSensors();
    this.getStats();
  }
};
</script>
