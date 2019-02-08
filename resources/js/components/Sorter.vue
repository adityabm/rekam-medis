<template>
  <span>
    <span v-show="sortColumn == columnName && sortDir == 'asc'" class="caret"></span>
    <span v-show="sortColumn == columnName && sortDir == 'desc'" class="dropup"><span class="caret"></span></span>
  </span>
</template>

<script>
    export default {
        props: ['columnName','sortColumn','sortDir'],
    }
</script>
