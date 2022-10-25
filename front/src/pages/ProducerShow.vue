<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>        <q-toolbar-title>
          Información del productor
        </q-toolbar-title>
      </q-toolbar>
    </q-header>
    <q-page-container>
      <q-page>
        <div class="row">
          <div class="col-12 col-sm-2"></div>
          <div class="col-12 col-sm-8">
            <q-card>
              <q-card-section class="q-py-xs">
                <div class="row">
                  <div class="col-6"><q-input disable dense outlined v-model="producer.nombres" label="NOMBRES(S)" required /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.apellidos" label="APELLIDOS" /></div>
                  <div class="col-4"><q-input disable dense outlined v-model="producer.ci" label="CI" /></div>
                  <div class="col-4"><q-input disable dense outlined v-model="producer.edad" label="EDAD" /></div>
                  <div class="col-4"><q-input disable dense outlined v-model="producer.nroFamilia" label="NO FAMILIA" /></div>
                  <div class="col-3"><q-input disable dense outlined v-model="producer.masculino" label="MASCULINO" /></div>
                  <div class="col-3"><q-input disable dense outlined v-model="producer.femenino" label="FEMENINO" /></div>
                  <div class="col-3"><q-input disable dense outlined v-model="producer.varones" label="VARONES" /></div>
                  <div class="col-3"><q-input disable dense outlined v-model="producer.mujeres" label="MUJERES" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.celular" label="CELULAR" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.provincia" label="PROVINCIA" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.departamento" label="1 DEPARTAMENTO" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.municipio" label="2 MUNICIPIO" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.comunidad" label="3 COMUNIDAD" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.superficie" label="4 SUPERFICIE CULTIVADA" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.semilla" label="5 SEMILLA UTILIZADA" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.abono" label="6 TIPO DE ABONO UTILIZADO" /></div>
                  <div class="col-12"><q-input disable dense outlined v-model="producer.maquinaria" label="7 MAQUINARIA Y HERRAMIENTAS EMPLEADAS" /></div>
                  <div class="col-12"><q-input disable dense outlined v-model="producer.riego" label="8 TIPO DE RIEGO AL QUE TIENE ACCESO" /></div>
                  <div class="col-12"><q-input disable dense outlined v-model="producer.quinua" label="9 CANTIDAD DE QUINUA RECOLECTADA POR HECTAREA" /></div>
                  <div class="col-12"><q-input disable dense outlined v-model="producer.asociacion" label="10 PERTENECE A ALGUNA ASOCIACIÓN?" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.si" label="SI" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.no" label="NO" /></div>
                  <div class="col-12"><q-input disable dense outlined v-model="producer.mejorar" label="11 COMO CREE QUE PODRÍA MEJORAR SU PRODUCCIÓN" /></div>

                  <div class="col-12 text-center flex flex-center">
                    <q-img v-if="producer.foto!=undefined" :src="url+'../imagenes/'+producer.foto" style="width: 200px; height: 200px;" />
                  </div>
                  <div class="col-12">
                    <q-btn class="full-width" label="Descargar Credencial" @click="imprimirCredencial(producer)" icon="credit_card" no-caps color="primary"/>
                  </div>
                  <div class="col-12">
                    <q-btn class="full-width" label="Descargar Credencial" icon-right="o_file_download" @click="excel" no-caps color="purple"/>
                  </div>
                </div>
              </q-card-section>
            </q-card>
          </div>
          <div class="col-12 col-sm-2"></div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import {date, exportFile, useQuasar} from 'quasar'
import {jsPDF} from "jspdf";
import {useCounterStore} from "stores/example-store";
import $ from 'jquery'
import QRCode from 'qrcode'
import xlsx from "json-as-xlsx"

export default {
  name: `ProducerShow`,
  data () {
    return {
      producer: {},
      url:process.env.API,
      urlfront:process.env.API_FRONT,
    }
  },
  created() {
    this.$q.loading.show()
    this.$api.get(`producer/${this.$route.params.id}`).then(res => {
      this.producer = res.data
      this.$q.loading.hide()
    })
  },
  methods:{
    excel(){
      let data = [
  {
    sheet: "Productores",
    columns: [
      /*{ label: "User", value: "user" }, // Top level data
      { label: "Age", value: (row) => row.age + " years" }, // Custom format
      { label: "Phone", value: (row) => (row.more ? row.more.phone || "" : "") }, // Run functions
      */
      {label:"id",value:"id"},
      {label:"nombres",value:"nombres"},
      {label:"apellidos",value:"apellidos"},
      {label:"ci",value:"ci"},
      {label:"edad",value:"edad"},
      {label:"nroFamilia",value:"nroFamilia"},
      {label:"masculino",value:"masculino"},
      {label:"femenino",value:"femenino"},
      {label:"varones",value:"varones"},
      {label:"mujeres",value:"mujeres"},
      {label:"celular",value:"celular"},
      {label:"provincia",value:"provincia"},
      {label:"departamento",value:"departamento"},
      {label:"municipio",value:"municipio"},
      {label:"comunidad",value:"comunidad"},
      {label:"superficie",value:"superficie"},
      {label:"semilla",value:"semilla"},
      {label:"abono",value:"abono"},
      {label:"maquinaria",value:"maquinaria"},
      {label:"riego",value:"riego"},
      {label:"quinua",value:"quinua"},
      {label:"asociacion",value:"asociacion"},
      {label:"si",value:"si"},
      {label:"no",value:"no"},
      {label:"mejorar",value:"mejorar"},
      {label:"fecha",value:"fecha"},
      {label:"hora",value:"hora"},
      {label:"user_id",value:"user_id"},
      {label:"created_at",value:"created_at"},
      {label:"updated_at",value:"updated_at"},
      {label:"foto",value:"foto"},
      {label:"url",value:"url"},
      { label: "Usuario", value: (row) => (row.user ? row.user.name || "" : "") }
    ],
    content: [this.producer],
  },
  /*{
    sheet: "Children",
    columns: [
      { label: "User", value: "user" }, // Top level data
      { label: "Age", value: "age", format: '# "years"' }, // Column format
      { label: "Phone", value: "user.more.phone", format: "(###) ###-####" }, // Deep props and column format
    ],
    content: [
      { user: "Manuel", age: 16, more: { phone: 9999999900 } },
      { user: "Ana", age: 17, more: { phone: 8765432135 } },
    ],
  },*/
]

let settings = {
  fileName: "Productores", // Name of the resulting spreadsheet
  //extraLength: 3, // A bigger number means that columns will be wider
  writeMode: 'writeFile', // The available parameters are 'WriteFile' and 'write'. This setting is optional. Useful in such cases https://docs.sheetjs.com/docs/solutions/output#example-remote-file
  writeOptions: {}, // Style options from https://github.com/SheetJS/sheetjs#writing-options
  //RTL: true, // Display the columns from right-to-left (the default value is false)
}

xlsx(data, settings) // Will download the excel file
    },
    imprimirCredencial(producer){
      console.log(producer)
      this.loading=true
      this.$api.post('base64',{imagen:producer.foto}).then(res=>{
        this.loading=false
        this.$q.notify({
          message: 'Credencial Generada',
          color: 'positive',
          icon: 'done'
        })
        // this.$q.dialog({
        //   title: 'Credencial',
        //   message: `<div style="text-align:center"><img src="${res.data}" style="width:100%"></div>`,
        //   html: true,
        //   persistent: true
        // })
        var doc = new jsPDF()
        var img = new Image()
        img.src = 'img/frontal.png'
        doc.addImage(img, 'jpg', 5, 5, 100, 55)
        img.src = 'img/atras.png'
        doc.setFont('helvetica','bold')

        doc.addImage(img, 'jpg', 105, 5, 100, 55)

        doc.saveGraphicsState();
        doc.setFillColor(220, 220, 220)
        doc.setGState(new doc.GState({opacity: 0.5}))
        doc.roundedRect(10, 22, 65, 8,1,1, 'FD')
        doc.roundedRect(10, 30, 65, 8,1,1, 'FD')
        doc.roundedRect(10, 38, 65, 8,1,1, 'FD')
        doc.restoreGraphicsState();

        doc.setTextColor(0)
        doc.setFontSize(8)
        let nombre=(producer.nombres==undefined||producer.nombres==null?'':producer.nombres)+" "+(producer.apellidos==undefined||producer.apellidos==null?'':producer.apellidos)
        let municipio=(producer.municipio==undefined||producer.municipio==null?'':producer.municipio)
        let departamento=(producer.departamento==undefined||producer.departamento==null?'':producer.departamento)
        doc.text(nombre, 42, 28,'center');
        doc.text(producer.ci==undefined||producer.ci==null?'':producer.ci, 42, 35,'center');
        doc.text(departamento+' '+ municipio, 42, 42,'center');
        doc.text(producer.id+'', 112, 47,'center');
        QRCode.toDataURL(this.urlfront+'/producerShow/'+producer.id)
          .then(url => {
            // console.log(url)
            doc.addImage(url, 'png', 140, 20, 30, 30);
              if (res.data!='') {
                doc.addImage(res.data, 'png', 80, 20, 25, 25);
              }
            // window.open(doc.output('bloburl'), '_blank')
            let time = new Date().getTime()
            doc.save(`${producer.nombres} ${producer.apellidos} ${time}.pdf`);
          })
          .catch(err => {
            console.error(err)
          })
        // var qrcode = new QRCode(document.getElementById("qr_code"), {
        //   text: producer.url,
        //   width: 128,
        //   height: 128,
        //   colorDark : "#000000",
        //   colorLight : "#ffffff",
        //   correctLevel : QRCode.CorrectLevel.H
        // });
        // setTimeout(() => {
        //   let base64Image = $('#qr_code img').attr('src');
        //   // console.log(producer.url)
        //   if (producer.url!='' && producer.url!=null && producer.url!=undefined) {
        //     doc.addImage(base64Image, 'png', 140, 20, 30, 30);
        //   }
        //   if (res.data!='') {
        //     doc.addImage(res.data, 'png', 80, 20, 25, 25);
        //   }
        //
        //   // console.log(producer)
        //   window.open(doc.output('bloburl'), '_blank')
        // }, 100);
      })

    },
  }
}
</script>

<style scoped>

</style>
