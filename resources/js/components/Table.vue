<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="(t, key) in titulos" :key="key" class="text-uppercase">
                        {{ t.titulo }}
                    </th>
                    <th v-if="visualizar.visivel || atualizar || remover.visivel"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave"> 
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo == 'texto'">
                            {{ valor }}
                        </span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">
                            {{ formataDataTempo(valor) }}
                        </span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/'+valor" width="40" height="40">
                        </span>
                    </td>

                    <td v-if="visualizar.visivel || atualizar.visivel || remover.visivel">
                        <button style="margin-right: 10px;" @click="setStore(obj)" v-if="visualizar.visivel" :data-bs-toggle="visualizar.dataToggle" :data-bs-target="visualizar.dataTarget" class="btn btn-outline-secondary btn-sm">Visualizar</button>
                        <button style="margin-right: 10px;" @click="setStore(obj)" :data-bs-toggle="atualizar.dataToggle" :data-bs-target="atualizar.dataTarget" v-if="atualizar.visivel" class="btn btn-outline-primary btn-sm">Atualizar</button>
                        <button @click="setStore(obj)" v-if="remover.visivel" :data-bs-toggle="remover.dataToggle" :data-bs-target="remover.dataTarget" class="btn btn-outline-danger btn-sm">Remover</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ["dados", "titulos", "chaves", "atualizar", "visualizar", "remover"],
    
    methods: {
        setStore(obj){
            this.$store.state.item = obj
            this.$store.state.transacao.status = ''
            this.$store.state.transacao.mensagem = ''
            this.$store.state.transacao.dados = ''
        },

        formataDataTempo(data) {
            if(!data) return ''

            data = data.split('T')

            let dataFormatada = data[0]
            dataFormatada = dataFormatada.split('-')
            dataFormatada = dataFormatada[2] + '/' + dataFormatada[1] + '/' + dataFormatada[0]

            let horaFormatada = data[1]
            horaFormatada = horaFormatada.split('.')
            horaFormatada = horaFormatada[0]

            let dataFinal = dataFormatada + ' ' + horaFormatada

            return dataFinal
        }
    },

    computed: {
        dadosFiltrados() {
            let campos = Object.keys(this.titulos)
            let dadosFiltrados = []
            this.dados.map((item, chave) => {
                let itemFiltrado = {}
                
                campos.forEach(campo => {
                    itemFiltrado[campo] = item[campo]
                })
                
                dadosFiltrados.push(itemFiltrado)
            }) 
            return dadosFiltrados
        }
    },
};
</script>