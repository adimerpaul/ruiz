<template>
<q-page>
  <div class="row">
    <div class="col-12">
      <div class="row">
        <div class="col-xs-6 col-sm-3 q-pa-xs">
          <q-input dense outlined label="Desde" v-model="fechaInicio" type="date">
            <template v-slot:prepend>
              <q-icon name="o_calendar_today"></q-icon>
            </template>
          </q-input>
        </div>
        <div class="col-xs-6 col-sm-3 q-pa-xs">
          <q-input dense outlined label="Hasta" v-model="fechaFin" type="date">
            <template v-slot:prepend>
              <q-icon name="o_calendar_today"></q-icon>
            </template>
          </q-input>
        </div>
        <div class="col-xs-12 col-sm-3 q-pa-xs"  v-if="store.user.tipo=='ADMINISTRADOR'">
          <q-select dense outlined label="Usuario" v-model="user" :options="users" @filter="filterFn" use-input >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey">
                  No results
                </q-item-section>
              </q-item>
            </template>
          </q-select>
        </div>
        <div class="col-xs-12 col-sm-3 q-pa-xs">
          <q-btn class="full-width" icon="o_search" label="Consultar" color="info" @click="producerGet" :loading="loading" />
        </div>
      </div>
    </div>
    <div class="col-12">
      <q-table :rows="producers" title="Control de productores" :rows-per-page-options="[0]" :columns="producerColumns" :filter="producerFilterData">
        <template v-slot:top>
          <div class="row full-width">
            <div class="col-4 q-pa-xs">
              <q-btn class="full-width" icon="add_circle" color="green" :label="$q.screen.lt.md?'':'Crear Productor'" @click="producerDialog=true" :loading="loading"  />
            </div>
            <div class="col-4 q-pa-xs">
              <q-input dense outlined v-model="producerFilterData" placeholder="Buscar" >
                <template v-slot:append>
                  <q-icon name="search"></q-icon>
                </template>
              </q-input>
            </div>
            <div class="col-4 q-pa-xs">
              <q-btn
                class="full-width"
                color="purple"
                icon-right="o_file_download"
                :label="$q.screen.lt.md?'':'Descargar csv'"
                no-caps
                @click="exportTable"
              />
            </div>
          </div>
        </template>
        <template v-slot:body-cell-opciones="props">
          <q-td :props="props" auto-width>
            {{props.row.id }}
            <q-btn-dropdown size="12px" label="Opciones" color="primary" dropdown-icon="more_vert" >
              <q-list>
                <q-item clickable @click="producerUpdateDialog=true;producerU=props.row">
                  <q-item-section>
                    <q-item-label>Editar</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item clickable @click="userDelete(props.row)">
                  <q-item-section>
                    <q-item-label>Eliminar</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item clickable @click="imprimirCredencial(props.row)">
                  <q-item-section>
                    <q-item-label>Imprimir credecial</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-btn-dropdown>
          </q-td>
        </template>
        <template v-slot:body-cell-foto="props">
          <q-td :props="props" auto-width>
            <a target="_blank" :href="url+'../imagenes/'+props.row.foto">{{props.row.foto}}</a>
          </q-td>
        </template>
        <template v-slot:body-cell-dato="props">
          <q-td :props="props" auto-width>
            <q-btn type="a" outline target="_blank" :href="urlfront+'/producerShow/'+props.row.id" label="Datos" icon="credit_card" size="10px" />
          </q-td>
        </template>
      </q-table>
      <pre>{{producers}}</pre>
    </div>
  </div>
  <q-dialog v-model="producerDialog" maximized>
    <q-card>
      <q-card-section class="row items-center q-mb-none">
        <div class="text-h6">Crear Productor</div>
        <q-space/>
        <q-btn icon="highlight_off" flat round dense v-close-popup />
      </q-card-section>
      <q-form @submit.prevent="producerCreate" class="q-pa-none q-ma-none">
      <q-card-section class="q-py-xs">
        <div class="row">
          <div class="col-6"><q-input dense outlined v-model="producer.nombres" label="NOMBRES(S)" required /></div>
          <div class="col-6"><q-input dense outlined v-model="producer.apellidos" label="APELLIDOS" /></div>
          <div class="col-2"><q-input dense outlined v-model="producer.ci" label="CI" /></div>
          <div class="col-2"><q-select dense outlined v-model="departamento" :options="departamentos" label="EXPEDIDO" /></div>
          <div class="col-4"><q-input dense outlined v-model="producer.edad" label="EDAD" /></div>
          <div class="col-4"><q-input dense outlined v-model="producer.nroFamilia" label="NO FAMILIA" /></div>
          <div class="col-3"><q-input dense outlined v-model="producer.masculino" label="MASCULINO" v-if="producer.nroFamilia!=undefined && producer.nroFamilia!=null && producer.nroFamilia!=''" /></div>
          <div class="col-3"><q-input dense outlined v-model="producer.femenino" label="FEMENINO" v-if="producer.nroFamilia!=undefined && producer.nroFamilia!=null && producer.nroFamilia!=''" /></div>
          <div class="col-3"><q-input dense outlined v-model="producer.varones" label="VARONES" v-if="producer.nroFamilia!=undefined && producer.nroFamilia!=null && producer.nroFamilia!=''" /></div>
          <div class="col-3"><q-input dense outlined v-model="producer.mujeres" label="MUJERES" v-if="producer.nroFamilia!=undefined && producer.nroFamilia!=null && producer.nroFamilia!=''" /></div>
          <div class="col-6"><q-input dense outlined v-model="producer.celular" label="CELULAR" /></div>
          <div class="col-6"><q-input dense outlined v-model="producer.provincia" label="PROVINCIA" /></div>
          <div class="col-6"><q-input dense outlined v-model="producer.departamento" label="1 DEPARTAMENTO" /></div>
          <div class="col-6"><q-input dense outlined v-model="producer.municipio" label="2 MUNICIPIO" /></div>
          <div class="col-6"><q-input dense outlined v-model="producer.comunidad" label="3 COMUNIDAD" /></div>
          <div class="col-6"><q-input dense outlined v-model="producer.superficie" label="4 SUPERFICIE CULTIVADA" /></div>
          <div class="col-6"><q-input dense outlined v-model="producer.semilla" label="5 SEMILLA UTILIZADA" /></div>
          <div class="col-6"><q-input dense outlined v-model="producer.abono" label="6 TIPO DE ABONO UTILIZADO" /></div>
          <div class="col-12"><q-input dense outlined v-model="producer.maquinaria" label="7 MAQUINARIA Y HERRAMIENTAS EMPLEADAS" /></div>
          <div class="col-12"><q-input dense outlined v-model="producer.riego" label="8 TIPO DE RIEGO AL QUE TIENE ACCESO" /></div>
          <div class="col-12"><q-input dense outlined v-model="producer.quinua" label="9 CANTIDAD DE QUINUA RECOLECTADA POR HECTAREA" /></div>
          <div class="col-6"><q-select :options="['SI','NO']" dense outlined v-model="producer.asociacion" label="10 PERTENECE A ALGUNA ASOCIACIÓN?" /></div>
          <div class="col-6"><q-input v-if="producer.asociacion=='SI'" dense outlined v-model="producer.si" label="NOMBRE DE LA ASOCIACION" /></div>
<!--          <div class="col-6"><q-input dense outlined v-model="producer.si" label="SI" /></div>-->
<!--          <div class="col-6"><q-input dense outlined v-model="producer.no" label="NO" /></div>-->
          <div class="col-12"><q-input dense outlined v-model="producer.mejorar" label="11 COMO CREE QUE PODRÍA MEJORAR SU PRODUCCIÓN" /></div>
          <div class="col-12 text-center flex flex-center">
            <q-uploader
              accept=".jpg, .png"
              @added="uploadFile"
              auto-upload
              max-files="1"
              label="Ingresar imagen para su producto"
              flat
              max-file-size="5000000"
              @rejected="onRejected"
              bordered
            />
            Subiendo {{percentage}}%
          </div>
<!--          <div class="col-12"><q-input dense outlined v-model="producer.url" label="URL" /></div>-->
        </div>
      </q-card-section>
      <q-card-section>
        <div class="row">
          <div class="col-12">
            <q-btn color="green" icon="check_circle" class="full-width" label="Crear" type="submit" :loading="loading"  />
          </div>
        </div>
      </q-card-section>
      </q-form>
    </q-card>
  </q-dialog>
  <q-dialog v-model="producerUpdateDialog">
    <q-card>
      <q-card-section class="row items-center q-mb-none">
        <div class="text-h6">Modificar Productor</div>
        <q-space/>
        <q-btn icon="highlight_off" flat round dense v-close-popup />
      </q-card-section>
      <q-form @submit.prevent="producerUpdate">
        <q-card-section>
          <div class="row">
            <div class="col-6"><q-input dense outlined v-model="producerU.nombres" label="NOMBRES(S)" required /></div>
            <div class="col-6"><q-input dense outlined v-model="producerU.apellidos" label="APELLIDOS" /></div>
            <div class="col-4"><q-input dense outlined v-model="producerU.ci" label="CI" /></div>
            <div class="col-4"><q-input dense outlined v-model="producerU.edad" label="EDAD" /></div>
            <div class="col-4"><q-input dense outlined v-model="producerU.nroFamilia" label="NO FAMILIA" /></div>
            <div class="col-3"><q-input dense outlined v-model="producerU.masculino" label="MASCULINO" /></div>
            <div class="col-3"><q-input dense outlined v-model="producerU.femenino" label="FEMENINO" /></div>
            <div class="col-3"><q-input dense outlined v-model="producerU.varones" label="VARONES" /></div>
            <div class="col-3"><q-input dense outlined v-model="producerU.mujeres" label="MUJERES" /></div>
            <div class="col-6"><q-input dense outlined v-model="producerU.celular" label="CELULAR" /></div>
            <div class="col-6"><q-input dense outlined v-model="producerU.provincia" label="PROVINCIA" /></div>
            <div class="col-6"><q-input dense outlined v-model="producerU.departamento" label="1 DEPARTAMENTO" /></div>
            <div class="col-6"><q-input dense outlined v-model="producerU.municipio" label="2 MUNICIPIO" /></div>
            <div class="col-6"><q-input dense outlined v-model="producerU.comunidad" label="3 COMUNIDAD" /></div>
            <div class="col-6"><q-input dense outlined v-model="producerU.superficie" label="4 SUPERFICIE CULTIVADA" /></div>
            <div class="col-6"><q-input dense outlined v-model="producerU.semilla" label="5 SEMILLA UTILIZADA" /></div>
            <div class="col-6"><q-input dense outlined v-model="producerU.abono" label="6 TIPO DE ABONO UTILIZADO" /></div>
            <div class="col-12"><q-input dense outlined v-model="producerU.maquinaria" label="7 MAQUINARIA Y HERRAMIENTAS EMPLEADAS" /></div>
            <div class="col-12"><q-input dense outlined v-model="producerU.riego" label="8 TIPO DE RIEGO AL QUE TIENE ACCESO" /></div>
            <div class="col-12"><q-input dense outlined v-model="producerU.quinua" label="9 CANTIDAD DE QUINUA RECOLECTADA POR HECTAREA" /></div>
            <div class="col-12"><q-input dense outlined v-model="producerU.asociacion" label="10 PERTENECE A ALGUNA ASOCIACIÓN?" /></div>
            <div class="col-6"><q-input dense outlined v-model="producerU.si" label="SI" /></div>
            <div class="col-6"><q-input dense outlined v-model="producerU.no" label="NO" /></div>
            <div class="col-12"><q-input dense outlined v-model="producerU.mejorar" label="11 COMO CREE QUE PODRIA MEJORAR SU PRODUCCIÓN" /></div>
            <div class="col-12 text-center flex flex-center">
              <q-uploader
                accept=".jpg, .png"
                @added="uploadFile2"
                auto-upload
                max-files="1"
                label="Ingresar imagen para su producto"
                flat
                max-file-size="5000000"
                @rejected="onRejected"
                bordered
              />
              Subiendo {{percentage}}%
            </div>
<!--            <div class="col-12"><q-input dense outlined v-model="producerU.url" label="URL" /></div>-->
          </div>
        </q-card-section>
        <q-card-section>
          <div class="row">
            <div class="col-12">
              <q-btn color="yellow-9" icon="o_edit" class="full-width" label="Modificar" type="submit" :loading="loading"  />
            </div>
          </div>
        </q-card-section>
      </q-form>
    </q-card>
  </q-dialog>
<!--  <div id="qr_code" style="display: none">-->
<!--  </div>-->
</q-page>
</template>

<script>
import {date, exportFile, useQuasar} from 'quasar'
import {jsPDF} from "jspdf";
import {useCounterStore} from "stores/example-store";
import $ from 'jquery'
import QRCode from 'qrcode'
import xlsx from "json-as-xlsx"

function wrapCsvValue (val, formatFn, row) {
  let formatted = formatFn !== void 0
    ? formatFn(val, row)
    : val

  formatted = formatted === void 0 || formatted === null
    ? ''
    : String(formatted)

  formatted = formatted.split('"').join('""')
  /**
   * Excel accepts \n and \r in strings, but some other CSV parsers do not
   * Uncomment the next two lines to escape new lines
   */
  // .split('\n').join('\\n')
  // .split('\r').join('\\r')

  return `"${formatted}"`
}
export default {
  name: `User`,
  data() {
    return {
      url:process.env.API,
      urlfront:process.env.API_FRONT,
      fechaInicio: date.formatDate(new Date(),'YYYY-MM-DD'),
      fechaFin: date.formatDate(new Date(),'YYYY-MM-DD'),
      store:useCounterStore(),
      producers: [],
      producerFilterData:"",
      producerDialog:false,
      producerUpdateDialog:false,
      loading:false,
      user:{},
      departamento:{value:'OR',label:'Oruro'},
      departamentos:[
        {value:'CH',label:'Chuquisaca'},
        {value:'LP',label:'La Paz'},
        {value:'CB',label:'Cochabamba'},
        {value:'OR',label:'Oruro'},
        {value:'PT',label:'Potosí'},
        {value:'TJ',label:'Tarija'},
        {value:'SC',label:'Santa Cruz'},
        {value:'BE',label:'Beni'},
        {value:'PD',label:'Pando'},
      ],
      users:[],
      usersF:[],
      producer:{},
      producerU:{},
      producerColumns:[
        {name:"opciones",field:"opciones",label:"Opciones"},
        {name:'fecha',field: row => row.fecha+' '+row.hora,label: 'fecha',sortable:true},
        {name:'nombres',field: 'nombres',label: 'nombres',sortable:true},
        {name:'apellidos',field: 'apellidos',label: 'apellidos',sortable:true},
        {name:'ci',field: 'ci',label: 'ci',sortable:true},
        {name:'dato',field: 'dato',label: 'dato',sortable:true},
        {name:'foto',field: 'foto',label: 'foto',sortable:true},
        {name:'edad',field: 'edad',label: 'edad',sortable:true},
        // {name:'fechanNacimiento',field: 'fechanNacimiento',label: 'fechanNacimiento',sortable:true},
        {name:'nroFamilia',field: 'nroFamilia',label: 'nroFamilia',sortable:true},
        {name:'varones',field: 'varones',label: 'varones',sortable:true},
        {name:'mujeres',field: 'mujeres',label: 'mujeres',sortable:true},
        {name:'celular',field: 'celular',label: 'celular',sortable:true},
        {name:'provincia',field: 'provincia',label: 'provincia',sortable:true},
        {name:'departamento',field: 'departamento',label: 'departamento',sortable:true},
        {name:'municipio',field: 'municipio',label: 'municipio',sortable:true},
        {name:'comunidad',field: 'comunidad',label: 'comunidad',sortable:true},
        {name:'superficie',field: 'superficie',label: 'superficie',sortable:true},
        {name:'semilla',field: 'semilla',label: 'semilla',sortable:true},
        {name:'abono',field: 'abono',label: 'abono',sortable:true},
        {name:'maquinaria',field: 'maquinaria',label: 'maquinaria',sortable:true},
        {name:'riego',field: 'riego',label: 'riego',sortable:true},
        {name:'quinua',field: 'quinua',label: 'quinua',sortable:true},
        {name:'asociacion',field: 'asociacion',label: 'asociacion',sortable:true},
        {name:'mejorar',field: 'mejorar',label: 'mejorar',sortable:true},
        // {name:'url',field: 'url',label: 'url',sortable:true},
        {name:'user_id',field: row=>row.user.name,label: 'user_id',sortable:true},
      ],
      percentage: 0,
    }
  },
  created() {
    this.producerGet()
    this.userGet()
  },
  methods: {
    uploadFile2 (file) {
      this.percentage = 0
      const fd = new FormData()
      fd.append('file', file[0])
      this.$api.post('upload', fd, {
        onUploadProgress: progressEvent => {
          this.percentage = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total))
        }
      }).then(response => {
        this.producerU.foto=response.data
        this.$q.notify({
          message: 'File uploaded',
          color: 'positive',
          icon: 'cloud_done'
        })
      }).catch(error => {
        this.$q.notify({
          message: 'Error uploading file',
          color: 'negative',
          icon: 'cloud_done'
        })
      })
    },
    uploadFile (file) {
      this.percentage = 0
      const fd = new FormData()
      fd.append('file', file[0])
      this.$api.post('upload', fd, {
        onUploadProgress: progressEvent => {
          this.percentage = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total))
        }
      }).then(response => {
        this.producer.foto=response.data
        this.$q.notify({
          message: 'File uploaded',
          color: 'positive',
          icon: 'cloud_done'
        })
      }).catch(error => {
        this.$q.notify({
          message: 'Error uploading file',
          color: 'negative',
          icon: 'cloud_done'
        })
      })
    },
    filterFn (val, update) {
      if (val === '') {
        update(() => {
          this.users = this.usersF
          // here you have access to "ref" which
          // is the Vue reference of the QSelect
        })
        return
      }
      update(() => {
        const needle = val.toLowerCase()
        this.users = this.usersF.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    userGet() {
      this.users=[{id:0,label:"Todos"}];
      this.$api.get('user').then(res => {
        res.data.forEach(r=>{
          r.label= r.name
          this.users.push(r)
        })
        this.usersF = this.users
        this.user=this.users[0]
      });
    },
    exportTable () {
      console.log(this.producers)

      let data = [
  {
    sheet: "Productores",
    columns: [
      { label: "User", value: "user" }, // Top level data
      { label: "Age", value: (row) => row.age + " years" }, // Custom format
      { label: "Phone", value: (row) => (row.more ? row.more.phone || "" : "") }, // Run functions
    ],
    content: [
      { user: "Andrea", age: 20, more: { phone: "11111111" } },
      { user: "Luis", age: 21, more: { phone: "12345678" } },
    ],
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
      // naive encoding to csv format
      /*
      const content = [this.producerColumns.map(col => wrapCsvValue(col.label))].concat(
        this.producers.map(row => this.producerColumns.map(col => wrapCsvValue(
          typeof col.field === 'function'
            ? col.field(row)
            : row[ col.field === void 0 ? col.name : col.field ],
          col.format,
          row
        )).join(','))
      ).join('\r\n')

      const status = exportFile(
        'table-export.csv',
        content,
        'text/csv'
      )

      if (status !== true) {
        this.$q.notify({
          message: 'Browser denied file download...',
          color: 'negative',
          icon: 'warning'
        })
      }
      */
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
    userDelete(producer){
      this.$q.dialog({
        title: 'Eliminar Productor',
        message: '¿Está seguro de eliminar este Productor?',
        cancel: 'Cancelar',
        ok: 'Eliminar',
        okColor: 'red',
        cancelColor: 'green',
        icon: 'highlight_off',
        color: 'red',
        persistent: true,
        showCancelButton: true,
        showOkButton: true,
        width: 'auto'
      }).onOk(() => {
        this.loading=true
        this.$api.delete(`producer/${producer.id}`).then(res => {
          this.loading=false
          this.producerGet()
        })
      })
    },
    producerCreate(){
      this.loading=true
      this.producer.user_id=this.store.user.id
      this.producer.ci=this.producer.ci+' '+ this.departamento.value
      this.$api.post('producer',this.producer).then(res => {
        // this.producerGet()
        this.producers.unshift(res.data)
        this.loading=false
        this.producer={}
        this.producerDialog=false
      }).catch(err=>{
        this.loading=false
        this.$q.notify({
          color: 'negative',
          textColor: 'white',
          message: "Nose inserto el dato"+err.response.data.message,
          position: 'top',
          icon: 'error'
        })
      }).finally(()=>{
        this.loading=false
      })
    },
    producerUpdate(){
      this.loading=true
      this.$api.put('producer/'+this.producerU.id,this.producerU).then(res => {
        this.producerGet()
        this.loading=false
        this.producerUpdateDialog=false
      }).catch(err=>{
        this.loading=false
        this.$q.notify({
          color: 'negative',
          textColor: 'white',
          message: err.response.data.message,
          position: 'top',
          icon: 'error'
        })
      })
    },
    producerGet() {
      this.loading=true
      this.$api.post('producerFilter',{
        'fechaInicio':this.fechaInicio,
        'fechaFin':this.fechaFin,
        'id':this.user.id,
      }).then(res => {
        this.loading=false
        this.producers = res.data;
      });
    },
    onRejected (rejectedEntries) {
      this.$q.notify({
        type: 'negative',
        message: `${rejectedEntries.length} el archivo paso las restricciones de validación`
      })
    },
  },
}
</script>

<style scoped>

</style>
