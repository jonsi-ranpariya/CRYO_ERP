<template>
  <p class="clearfix mb-0">
    <span class="float-md-left d-block d-md-inline-block mt-25">
      COPYRIGHT  © {{ new Date().getFullYear() }}
      <b-link
        class="ml-25"
        href="#"
        target="_blank"
      >CEPL</b-link>
      <span class="d-none d-sm-inline-block">, All rights Reserved</span>
    </span>

    <span class="float-md-right d-none d-md-block">Hand-crafted &amp; Made with
      <b-link
        class="ml-25"
        href="https://www.teacodes.com"
        target="_blank"
      >
          <feather-icon
              icon="HeartIcon"
              size="21"
              class="text-danger stroke-current"
          />
      </b-link>
    </span>
  </p>
</template>

<script>
import { BLink } from 'bootstrap-vue'

export default {
  components: {
    BLink,
  },
}
</script>
