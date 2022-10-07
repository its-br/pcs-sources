import i18n from '@/plugins/i18n'

const validationCardEvent = {
    methods: {
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
      validateFields(fields) {
        const Errors = {};
        let IsValid = true;
        for(let property in fields) {
          const errors = this.validateField(property, fields[property]);
          if(errors.length) {
            IsValid = false;
          }
          Errors[property] = errors;
        }
        Errors.IsValid = IsValid;
        return Errors;
      }
    },
    data: () => ({
      validationRules: {
        dialog_picked_time: {
            rules: [
                value => !!value || i18n.t('mixinsValidation.RequiredField'),
                value => (value.length > 4) || i18n.t('mixinsValidation.InvalidTime')
            ]
            },
        dialog_picked_date: {
            rules: [
                value => !!value || i18n.t('mixinsValidation.RequiredField'),
                value => (value.replace('-','').length > 8) || i18n.t('mixinsValidation.InvalidDate')
            ]
            },
    }
    })
  }
  
  export default validationCardEvent;