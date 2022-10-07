// https://www.codepanion.com/posts/2020-02-08-implement-form-validation-from-scratch-using-vue-js-mixins/
// mixins/validationMixin.js


import i18n from '@/plugins/i18n'

const validationMixin = {
    methods: {
      // add methods
      validateField(inputName, value) {
        return this.validationRules[inputName].rules
          .filter(rule => {
            const isValid = rule(value);
            if(isValid !== true) {
              return isValid;
            }
          })
          .map(rule => rule(value))
      },
      validateForm(form) {
        const formErrors = {};
        let formIsValid = true;
        for(let property in form) {
          const errors = this.validateField(property, form[property]);
          if(errors.length) {
            formIsValid = false;
          }
    
          formErrors[property] = errors;
        }
        formErrors.formIsValid = formIsValid;
        return formErrors;
      }
    },
    data: () => ({
      validationRules: {
        // StepOne
        maritime_agent_cnpj: {
            rules: [
                value => !!value || i18n.t('mixinsValidation.RequiredField'),
                value => (value.length >= 18) || i18n.t('mixinsValidation.RequiredField')
            ]
            },
        user_agent_cnpj: {
            rules: [
                value => !!value || i18n.t('mixinsValidation.RequiredField'),
                value => (value.length >= 14) || i18n.t('mixinsValidation.InvalidCNPJ')
            ]
            },
        list_provier: {
            rules: [
                value => !!value || i18n.t('mixinsValidation.RequiredField'),
            ]
            },
        carrier_code: {
            rules: [
                value => !!value || i18n.t('mixinsValidation.RequiredField'),
                value => (value.length >= 4) || i18n.t('mixinsValidation.InvalidCode')
            ]
            },
        vessel_imo: {
            rules: [
                value => !!value || i18n.t('mixinsValidation.RequiredField'),
                value => (value.length >= 7) || i18n.t('mixinsValidation.InvalidCode')
            ]
            },
        carrier_voyage_number: {
            rules: [
                value => !!value || i18n.t('mixinsValidation.RequiredField'),
                value => (value.length >=1) || i18n.t('mixinsValidation.InvalidCode')
            ]
            },
        un_location_code: {
            rules: [
                value => !!value || i18n.t('mixinsValidation.RequiredField'),
                value => (value.length >= 5) || i18n.t('mixinsValidation.InvalidCode')
            ]
            },
        // DialogTransportCall
        order: {
            rules: [
              value => !!value || i18n.t('mixinsValidation.RequiredField'),
              value => (value >=1) || i18n.t('mixinsValidation.InvalidNumber')
            ]
          },
          tcall_id: {
            rules: [
                value => !!value || i18n.t('mixinsValidation.RequiredField'),
            ]
            },
          port_facility: {
            rules: [
                value => !!value || i18n.t('mixinsValidation.RequiredField'),
                value => (value.length >= 18) || i18n.t('mixinsValidation.InvalidCNPJ')
            ]
            },
        mooring_operator: {
            rules: [
                value => !!value || i18n.t('mixinsValidation.RequiredField'),
                value => (value.length >= 18) || i18n.t('mixinsValidation.InvalidCNPJ')
            ]
            },
        tug_operator: {
            rules: [
                value => !!value || i18n.t('mixinsValidation.RequiredField'),
                value => (value.length >= 18) || i18n.t('mixinsValidation.InvalidCNPJ')
            ]
            },
        // DialogMaritimeAgency
        maritime_agency_id:
         {
          rules: [
            value => !!value || i18n.t('mixinsValidation.RequiredField'),
            value => (value.length >= 18) || i18n.t('mixinsValidation.InvalidCNPJ')
          ]
        },
        responsability_code: {
          rules: [
            value => !!value || i18n.t('mixinsValidation.RequiredField'),
          ]
        }
    //  
    }
    })
  }
  
  export default validationMixin;