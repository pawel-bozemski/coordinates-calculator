<template>
  <div id="form" class="container">
    <button
      class="btn btn-info"
      type="submit"
      @click="getGeoLocation"
      v-if="this.showGeoButton"
    >
      Get your location
    </button>
    <form class="row g-3 justify-content-center" @submit.prevent>
      <Inputs title="Point 1" v-model="this.coordA" />
      <Inputs title="Point 2" v-model="this.coordB" />
      <button class="btn btn-primary" type="submit" @click="calculateCoords">
        Check distance
      </button>
    </form>
  </div>
</template>

<script>
import Inputs from "./Inputs.vue";
export default {
  name: "Form-component",
  components: {
    Inputs,
  },
  data() {
    return {
      coordA: {
        lat: "",
        long: "",
        hemisphereLat: "N",
        hemisphereLong: "E",
      },
      coordB: {
        lat: "",
        long: "",
        hemisphereLat: "N",
        hemisphereLong: "E",
      },
      showGeoButton: true,
    };
  },
  watch: {},
  methods: {
    async calculateCoords() {
      if (
        this.coordA.lat !== "" &&
        this.coordA.lat <= 85 &&
        this.coordA.long !== "" &&
        this.coordA.long <= 180 &&
        this.coordB.lat !== "" &&
        this.coordB.lat <= 85 &&
        this.coordB.long <= 180 &&
        this.coordB.long !== ""
      ) {
        // link to backend/calc.php
        await fetch("http://localhost/calc/backend/calc.php", {
          method: "POST",
          body: JSON.stringify({
            coordA: this.coordA,
            coordB: this.coordB,
          }),
          mode: "cors",
        })
          .then((response) => response.json())
          .then((response) => (this.$parent.calculatedLength = response));
        this.$emit("update", [this.coordA, this.coordB]);
      }
    },
    getGeoLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
          if (position.coords.latitude < 0) {
            this.coordA.lat = parseFloat(position.coords.latitude) * -1;
            this.coordA.hemisphereLat = "S";
          } else {
            this.coordA.lat = position.coords.latitude;
          }
          if (position.coords.longitude < 0) {
            this.coordA.long = parseFloat(position.coords.longitude) * -1;
            this.coordA.hemisphereLong = "W";
          } else {
            this.coordA.long = position.coords.longitude;
          }
        });
      } else {
        alert("This browser does not support geolocation");
        this.showGeoButton = false;
      }
      const nav = navigator.geolocation.watchPosition(
        function () {},
        function (error) {
          if (error.code == error.PERMISSION_DENIED) {
            this.showGeoButton = false;
            alert(
              "If You want to use geolocation allow browser to get Your location"
            );
          }
        }
      );
      setTimeout(() => {
        navigator.geolocation.clearWatch(nav);
      }, 2000);
    },
  },
};
</script>

<style scoped lang="scss">
.btn-primary {
  width: 20%;
}
.btn-info {
  margin-bottom: 20px;
}
</style>
