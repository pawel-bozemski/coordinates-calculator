<template>
  <div class="row">
    <div class="col-md-12">
      <h2>{{ this.title }}</h2>
    </div>
    <div class="col-md-6">
      <label class="form-label">Latitude</label>
      <div class="input-group">
        <input
          pattern="[0-9]+([\.,][0-9]+)?"
          step="0.0000001"
          min="0"
          max="85"
          type="number"
          class="form-control"
          required
          v-model="modelVal.lat"
          @keypress="checkNegative($event)"         
        />
        <select class="form-select" required v-model="modelVal.hemisphereLat">
          <option selected>N</option>
          <option>S</option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <label class="form-label">Longitude</label>
      <div class="input-group">
        <input
          pattern="[0-9]+([\.,][0-9]+)?"
          step="0.0000001"
          type="number"
          class="form-control"
          required
          v-model="modelVal.long"
          min="0"
          max="180"
          @keypress="checkNegative($event)"          
        />
        <select class="form-select" required v-model="modelVal.hemisphereLong">
          <option selected>E</option>
          <option>W</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent, computed } from "vue";

export default defineComponent({
  name: "Inputs-component",
  emits: ["update:modelValue"],
  props: {
    modelValue: {
      type: Object,
      default: () => ({}),
    },
    title: {
      type: String,
    },
  },
  setup(props, { emit }) {
    const modelVal = computed({
      get: () => props.modelValue,
      set: (value) => emit("update:modelValue", value),
    });

    return { modelVal };
  },
  methods: {
    checkNegative(e) {
      if (e.key == "-") {
        e.preventDefault();
        return false;
      }
      if (
        !Number.isInteger(e.target.valueAsNumber) &&
        !isNaN(e.target.valueAsNumber)
      ) {
        const decimalCount = e.target.value.split(".")[1].length;
        if (decimalCount > 7) {
          e.preventDefault();
          return false;
        }
      }
    },
  },
});
</script>

<style scoped lang="scss">
.row {
  margin-top: 20px;
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
  appearance: none;
}

/* Firefox */
input[type="number"] {
  -moz-appearance: textfield;
  appearance: none;
}
</style>
