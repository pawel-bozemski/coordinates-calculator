<template>
  <div>
    <Form @update="onChildUpdate" />
    <Results
      v-if="this.calculatedLength !== ''"
      :result="this.calculatedLength"
    />
    <Map 
    v-if="this.coords.length !== 0"
    :coord="this.coords" />
  </div>
</template>

<script>
import Form from "./Form.vue";
import Results from "./Results.vue";
import Map from "./Map.vue";

export default {
  name: "Main-component",
  components: {
    Form,
    Results,
    Map,
  },
  data() {
    return {
      coords: [],
      calculatedLength: "",
    };
  },
  methods: {
    onChildUpdate(newValue) {
      this.coords = newValue;
    },
  },
};
</script>

<style scoped lang="scss">
#form {
  margin-top: 30px;
}
</style>
