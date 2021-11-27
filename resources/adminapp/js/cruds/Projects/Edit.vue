<template>
  <div class="container-fluid">
    <form @submit.prevent="submitForm">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">edit</i>
              </div>
              <h4 class="card-title">
                {{ $t('global.edit') }}
                <strong>{{ $t('cruds.project.title_singular') }}</strong>
              </h4>
            </div>
            <div class="card-body">
              <back-button></back-button>
            </div>
            <div class="card-body">
              <bootstrap-alert />
              <div class="row">
                <div class="col-md-12">
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.name,
                      'is-focused': activeField == 'name'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.project.fields.name')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.name"
                      @input="updateName"
                      @focus="focusField('name')"
                      @blur="clearFocus"
                      required
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.owner,
                      'is-focused': activeField == 'owner'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.project.fields.owner')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.owner"
                      @input="updateOwner"
                      @focus="focusField('owner')"
                      @blur="clearFocus"
                      required
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.address,
                      'is-focused': activeField == 'address'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.project.fields.address')
                    }}</label>
                    <textarea
                      class="form-control"
                      rows="5"
                      :value="entry.address"
                      @input="updateAddress"
                      @focus="focusField('address')"
                      @blur="clearFocus"
                    ></textarea>
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.whatsapp,
                      'is-focused': activeField == 'whatsapp'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.project.fields.whatsapp')
                    }}</label>
                    <input
                      class="form-control"
                      type="number"
                      step="1"
                      :value="entry.whatsapp"
                      @input="updateWhatsapp"
                      @focus="focusField('whatsapp')"
                      @blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.start_date,
                      'is-focused': activeField == 'start_date'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.project.fields.start_date')
                    }}</label>
                    <datetime-picker
                      class="form-control"
                      type="text"
                      picker="date"
                      :value="entry.start_date"
                      @input="updateStartDate"
                      @focus="focusField('start_date')"
                      @blur="clearFocus"
                      required
                    >
                    </datetime-picker>
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.due_date,
                      'is-focused': activeField == 'due_date'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.project.fields.due_date')
                    }}</label>
                    <datetime-picker
                      class="form-control"
                      type="text"
                      picker="date"
                      :value="entry.due_date"
                      @input="updateDueDate"
                      @focus="focusField('due_date')"
                      @blur="clearFocus"
                      required
                    >
                    </datetime-picker>
                  </div>
                  <div class="form-group">
                    <label>{{ $t('cruds.project.fields.photo') }}</label>
                    <attachment
                      :route="getRoute('projects')"
                      :collection-name="'project_photo'"
                      :media="entry.photo"
                      :model-id="$route.params.id"
                      :max-file-size="2"
                      :component="'pictures'"
                      :accept="'image/*'"
                      @file-uploaded="insertPhotoFile"
                      @file-removed="removePhotoFile"
                      :max-files="1"
                    />
                  </div>
                  <div class="form-group">
                    <label>{{ $t('cruds.project.fields.galery') }}</label>
                    <attachment
                      :route="getRoute('projects')"
                      :collection-name="'project_galery'"
                      :media="entry.galery"
                      :model-id="$route.params.id"
                      :max-file-size="2"
                      :component="'pictures'"
                      :accept="'image/*'"
                      @file-uploaded="insertGaleryFile"
                      @file-removed="removeGaleryFile"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <vue-button-spinner
                class="btn-primary"
                :status="status"
                :isLoading="loading"
                :disabled="loading"
              >
                {{ $t('global.save') }}
              </vue-button-spinner>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import Attachment from '@components/Attachments/Attachment'

export default {
  components: {
    Attachment
  },
  data() {
    return {
      status: '',
      activeField: ''
    }
  },
  computed: {
    ...mapGetters('ProjectsSingle', ['entry', 'loading'])
  },
  beforeDestroy() {
    this.resetState()
  },
  watch: {
    '$route.params.id': {
      immediate: true,
      handler() {
        this.resetState()
        this.fetchEditData(this.$route.params.id)
      }
    }
  },
  methods: {
    ...mapActions('ProjectsSingle', [
      'fetchEditData',
      'updateData',
      'resetState',
      'setName',
      'setOwner',
      'setAddress',
      'setWhatsapp',
      'setStartDate',
      'setDueDate',
      'insertPhotoFile',
      'removePhotoFile',
      'insertGaleryFile',
      'removeGaleryFile'
    ]),
    updateName(e) {
      this.setName(e.target.value)
    },
    updateOwner(e) {
      this.setOwner(e.target.value)
    },
    updateAddress(e) {
      this.setAddress(e.target.value)
    },
    updateWhatsapp(e) {
      this.setWhatsapp(e.target.value)
    },
    updateStartDate(e) {
      this.setStartDate(e.target.value)
    },
    updateDueDate(e) {
      this.setDueDate(e.target.value)
    },
    getRoute(name) {
      return `${axios.defaults.baseURL}${name}/media`
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'projects.index' })
          this.$eventHub.$emit('update-success')
        })
        .catch(error => {
          this.status = 'failed'
          _.delay(() => {
            this.status = ''
          }, 3000)
        })
    },
    focusField(name) {
      this.activeField = name
    },
    clearFocus() {
      this.activeField = ''
    }
  }
}
</script>
