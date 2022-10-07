export const sha256 = (message) => {
  // hash the message
  return window.crypto.subtle.digest('SHA-256', new TextEncoder().encode(message))
  .then((hash)=>{
    const hashArray = Array.from(new Uint8Array(hash));
    // convert bytes to hex string                  
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    return hashHex;
  });
}
export const randomCodeVerifier = () => {
  return btoa(btoa(crypto.randomUUID()));
}
export const getCodeChallenge = (codeVerifier, alg = 'S256') => {
  return window.crypto.subtle.digest('SHA-256', new TextEncoder().encode(codeVerifier))
  .then((hashBytes) => {
    return btoa(String.fromCharCode.apply(null, new Uint8Array(hashBytes)))
      .replace(/\+/g, '-')
      .replace(/\//g, '_')
      .replace(/=+$/, '');
  });
}
export const base64UrlEncode = (bytes) => {
  return btoa(String.fromCharCode.apply(null, new Uint8Array(bytes)))
    .replace(/\+/g, '-')
    .replace(/\//g, '_')
    .replace(/=+$/, '');
}
export const base64UrlDecode = (base64) => {
    return atob(base64
      .replace(/\-/g, '+')
      .replace(/\_/g, '/'));
}
export const parseJwt = (token) => {
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
  var jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
      return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
  }).join(''));

  return JSON.parse(jsonPayload);
}
export const genPcsJwt = (cnpj, user_agent = null) => {
  if (user_agent == null){
    user_agent = cnpj
  }
  var payload = {
    "cnpj": cnpj.replace(/[^0-9]/g, ''),
    "user_agent": user_agent.replace(/[^0-9]/g, '')
  }
  payload = JSON.stringify(payload);
  payload = Buffer.from(payload).toString('base64');
  payload = payload.replace(/=/g, '')
  let jwt = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9." + payload + ".NTXU-UFK3NMF7S2Jpbt7gfPgNgmuDDYWjGBqNG2IpoM" 
  // this.$store.state.PCSAuthorization = jwt;
  // this.$store.commit('setPCSAuthorization', jwt)
  return jwt;
}
/**
 * 
 * @param {*} datetime Format: "AAAA-MM-DD HH:mm:ssZ" 
 * @returns {Date}
 */
export const parseDatetime = (datetime) => {
  datetime = datetime.replace("Z","")
  var parts = datetime.slice(0, -1).split(' ')
  var dateParts = parts[0].split('-')
  var timeParts = parts[1].split(':')
  return new Date(parseInt(dateParts[0]),parseInt(dateParts[1])-1, parseInt(dateParts[2]), parseInt(timeParts[0]),parseInt(timeParts[1]),parseInt(timeParts[2]))
}
export const isNewDatetime = (datetime1, datetime2) => {
  var d1 = parseDatetime(datetime1)
  var d2 = parseDatetime(datetime2)
  return d1 < d2
}
