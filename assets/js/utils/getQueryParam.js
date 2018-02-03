/**
 * Created by cahyo on 09/04/2017.
 */
export default function (url, param) {
  if (url && param) {
    let index = 0
    const objectLength = Object.keys(param).length
    for (let key in param) {
      if (param.hasOwnProperty(key)) {
        index = index + 1
        url = objectLength === index ? url + key + '=' + param[key] : url + key + '=' + param[key] + '&'
      }
    }

    return url
  }
}
