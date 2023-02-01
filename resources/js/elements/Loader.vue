<template>
    <div class="wrapper">
        <span class="loader"></span>
    </div>
</template>

<script>
export default {}
</script>

<style scoped>
.wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
}
    .loader {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  border-top: 3px solid black;
  border-right: 3px solid transparent;
  box-sizing: border-box;
  animation: rotation .5s linear infinite;
}

@keyframes rotation {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
