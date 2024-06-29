<template>
	<div class="hump">
	<span class="h">H</span>
	<span class="u">U</span>
	<span class="m">M</span>
	<span class="p">P</span>
</div>
</template>

<script>
export default {
  name: 'HUMP'
}
</script>

<style lang="scss">
.hump {
  display: inline-block;

  span {
    display: inline-block;
    font-weight: bold;
    text-shadow: 3px 3px 3px var(--background-dark);
  }

  .h {
    color: chocolate;
    rotate: -12deg;
  }

  .u {
    rotate: 10deg;
  }

  .m {
    rotate: -5deg;
    color: rgb(59, 153, 153);
  }

  .p {
    color: darkolivegreen;
    rotate: 6deg;
  }
}
</style>
