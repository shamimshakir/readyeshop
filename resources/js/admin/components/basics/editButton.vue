<template>
   <router-link :to="{ name: this.column.class, params: { id: row.id } }" class="btn btn-info btn-sm">Edit</router-link >
</template>

<script>
export default {
    props: ["row", "column"],
};
</script>
