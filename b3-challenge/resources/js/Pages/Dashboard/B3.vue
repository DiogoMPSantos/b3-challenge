<script setup>
defineProps({ ativos: Array , dataset_balqty: Array, dataset_tradavrgpric: Array, labels: Array, current_ativo: String})
</script>

<template>
  <v-card>
    <v-layout>
      <v-app-bar :elevation="16" rounded title="B3 Charts" class="bg-deep-purple"></v-app-bar>
      <v-navigation-drawer
        permanent
        location="right"
        class="bg-deep-purple"
        theme="dark"
      >
        <template v-slot:prepend>
          <v-list-item
            lines="two"
            prepend-avatar="https://randomuser.me/api/portraits/men/81.jpg"
            title="Diogo Santos"
            subtitle="Logged in"
          ></v-list-item>
        </template>

        <v-divider></v-divider>

        <v-list density="compact" nav>
          <v-list-item prepend-icon="mdi-home-city" title="Home" value="home"></v-list-item>
        </v-list>
      </v-navigation-drawer>


        <v-main style="min-height: 300px;">
          <v-form action="/" method="get">
            <v-combobox
              name="ativo"
              style="width: 50%; margin: 20px;"
              clearable
              :active = true
              :model-value = this.current_ativo
              label="Selecione o Ativo e clique em GERAR GRÁFICO para exibir o gráfico correspondente"
              :items= "this.ativos"
            ></v-combobox>
            <v-btn type="submit" class="mt-2" style="margin: 20px;">Gerar gráfico</v-btn>
          </v-form>

          <p class="font-weight-bold text-center">
            {{ current_ativo }} Chart
          </p>
        
          <v-divider></v-divider>

          <Line :data="data" :options="options" style="max-height: 600px;" />
          
        </v-main>
    </v-layout>
  </v-card>
</template>

<script>

import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js'
import { Line } from 'vue-chartjs'

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
)

export default {
  name: 'LineChart',
  components: {
    Line
  },
  data() {
    return {
      data: {
          labels: this.$props.labels,
          datasets: [
            {
              label: 'Quantidade de Saldo',
              backgroundColor: 'blue',
              data: this.$props.dataset_balqty
            },
            {
              label: 'Preço Médio',
              backgroundColor: 'red',
              data: this.$props.dataset_tradavrgpric
            }
          ]
      },
      options: {
          responsive: true,
          maintainAspectRatio: false
      }
    }
  }
}
</script>