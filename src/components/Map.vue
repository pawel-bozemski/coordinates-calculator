<template>
  <GMapMap
    class="map"
    :center="this.center"
    :zoom="this.zoom"
    map-type-id="terrain"
    :options="{
      zoomControl: true,
      mapTypeControl: false,
      scaleControl: false,
      streetViewControl: false,
      rotateControl: false,
      fullscreenControl: false,
    }"
  >
    <GMapMarker
      :key="index"
      v-for="(m, index) in markers"
      :position="m.position"
    />
    <GMapPolyline :path="path" :editable="true" ref="polyline" />
  </GMapMap>
</template>

<script>
export default {
  name: "Map-component",
  props: ["coord"],
  mounted() {
    this.coord.forEach((e) => {
      const coord = { position: {} };
      if (e.hemisphereLat == "S") {
        coord.position.lat = e.lat * -1;
      } else {
        coord.position.lat = e.lat;
      }
      if (e.hemisphereLong == "W") {
        coord.position.lng = e.long * -1;
      } else {
        coord.position.lng = e.long;
      }
      this.markers.push(coord);
    });

    this.markers.forEach((e) => {
      this.path.push(e.position);
    });
    this.center.lat =
      (this.markers[0].position.lat + this.markers[1].position.lat) / 2;
    this.center.lng =
      (this.markers[0].position.lng + this.markers[1].position.lng) / 2;
    this.getZoom(
      this.markers[0].position.lat,
      this.markers[0].position.lng,
      this.markers[1].position.lat,
      this.markers[1].position.lng
    );
  },
  watch: {
    coord() {
      this.center = {};
      this.markers = [];
      this.path = [];
      this.coord.forEach((e) => {
        const coord = { position: {} };
        if (e.hemisphereLat == "S") {
          coord.position.lat = e.lat * -1;
        } else {
          coord.position.lat = e.lat;
        }
        if (e.hemisphereLong == "W") {
          coord.position.lng = e.long * -1;
        } else {
          coord.position.lng = e.long;
        }
        this.markers.push(coord);
      });

      this.markers.forEach((e) => {
        this.path.push(e.position);
      });
      this.center.lat =
        (this.markers[0].position.lat + this.markers[1].position.lat) / 2;
      this.center.lng =
        (this.markers[0].position.lng + this.markers[1].position.lng) / 2;
      this.getZoom(
        this.markers[0].position.lat,
        this.markers[0].position.lng,
        this.markers[1].position.lat,
        this.markers[1].position.lng
      );
    },
  },
  methods: {
    latRad(lat) {
      const sin = Math.sin((lat * Math.PI) / 180);
      const radX2 = Math.log((1 + sin) / (1 - sin)) / 2;
      return Math.max(Math.min(radX2, Math.PI), -Math.PI) / 2;
    },
    getZoom(lat_a, lng_a, lat_b, lng_b) {
      let latDif = Math.abs(this.latRad(lat_a) - this.latRad(lat_b));
      let lngDif = Math.abs(lng_a - lng_b);
      let latFrac = latDif / Math.PI;
      let lngFrac = lngDif / 360;

      let lngZoom = Math.log(1 / latFrac) / Math.log(2);
      let latZoom = Math.log(1 / lngFrac) / Math.log(2);
      this.zoom = Math.min(lngZoom, latZoom);
    },
  },
  data() {
    return {
      zoom: 5,
      center: {},
      markers: [],
      path: [],
    };
  },
};
</script>

<style scoped lang="scss">
.map {
  margin-top: 30px;
  width: 100%;
  height: 500px;
}
</style>
