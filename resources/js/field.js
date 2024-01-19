import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-nova-busy-resource-field', IndexField)
  // app.component('detail-nova-busy-resource-field', DetailField)
  app.component('form-nova-busy-resource-field', FormField)
})
