<template>
  <span v-if="status == 1" class="badge badge-success">Active</span>
  <span v-else class="badge badge-danger">Inactive</span>
</template>

<script>
export default {
  name: "StatusBadge",
  props: ["status"],
};
</script>
