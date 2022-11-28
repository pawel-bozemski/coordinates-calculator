<template>
  <div>
    <div class="col-md12">
        <p class="text-center fw-bold fs-2">Distance is: {{ this.result }} m or {{ Math.round(this.result/1000)}} km</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "Results-component",
  props: ["result"],
};
</script>

<style scoped lang="scss">
.col-md12{
  margin-top: 30px;
}
</style>
