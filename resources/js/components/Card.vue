<template>
    <div class="card mb-4">
        <div class="card-header">.: {{ titulo }}</div>
        <!-- Body -->
        <div class="card-body">
            <slot name="conteudo"></slot>
        </div>
        <!-- Footer -->
        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end">
            <slot name="rodape"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['titulo']
    }
</script>