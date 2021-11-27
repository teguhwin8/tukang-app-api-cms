<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">remove_red_eye</i>
            </div>
            <h4 class="card-title">
              {{ $t('global.view') }}
              <strong>{{ $t('cruds.project.title_singular') }}</strong>
            </h4>
          </div>
          <div class="card-body">
            <back-button></back-button>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <div class="table">
                    <tbody>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.project.fields.name') }}
                        </td>
                        <td>
                          {{ entry.name }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.project.fields.owner') }}
                        </td>
                        <td>
                          {{ entry.owner }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.project.fields.address') }}
                        </td>
                        <td>
                          {{ entry.address }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.project.fields.whatsapp') }}
                        </td>
                        <td>
                          {{ entry.whatsapp }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.project.fields.start_date') }}
                        </td>
                        <td>
                          {{ entry.start_date }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.project.fields.due_date') }}
                        </td>
                        <td>
                          {{ entry.due_date }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.project.fields.photo') }}
                        </td>
                        <td>
                          <datatable-pictures :row="entry" :field="'photo'">
                          </datatable-pictures>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.project.fields.galery') }}
                        </td>
                        <td>
                          <datatable-pictures :row="entry" :field="'galery'">
                          </datatable-pictures>
                        </td>
                      </tr>
                    </tbody>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import DatatablePictures from '@components/Datatables/DatatablePictures'

export default {
  components: {
    DatatablePictures
  },
  data() {
    return {}
  },
  beforeDestroy() {
    this.resetState()
  },
  computed: {
    ...mapGetters('ProjectsSingle', ['entry'])
  },
  watch: {
    '$route.params.id': {
      immediate: true,
      handler() {
        this.resetState()
        this.fetchShowData(this.$route.params.id)
      }
    }
  },
  methods: {
    ...mapActions('ProjectsSingle', ['fetchShowData', 'resetState'])
  }
}
</script>
