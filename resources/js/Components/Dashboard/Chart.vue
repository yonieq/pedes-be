<template>
    <charts-css
        heading="Coffee count"
        type="bar"
        :labels="['Mon', 'Tue', 'Wed']"
        :datasets="[{ values: [4, 2, 70] }]"
    />
</template>

<script>
import "chart.css";
</script>
