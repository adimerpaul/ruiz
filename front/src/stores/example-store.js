import { defineStore } from 'pinia';

export const useCounterStore = defineStore('counter', {
  state: () => ({
    counter: 0,
    isLoggedIn:!!localStorage.getItem('tokenruiz'),
    user:{},
    producerSearchs:[],
    producerSearch:'',
    producer:{},
    produces:[],
  }),
  getters: {
    doubleCount: (state) => state.counter * 2,
  },
  actions: {
    increment() {
      this.counter++;
    },
  },
});
