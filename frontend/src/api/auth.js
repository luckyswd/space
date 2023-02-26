import {instance} from "./config";

const PATH = 'user'

export const auth = {
  register: async (data) => {
    return await instance.post(`${PATH}/new`, data)
      .then(r => {
        console.log('Регистрация прошла успешно!')
      })
      .catch(err => {
        console.log('Что-то пошло не так!')
      })
  },
  login: async (data) => {
    await instance.post(`${PATH}/login`, data)
      .then(r => {
        auth.saveToken(r.data.token)
      })
      .catch(err => console.log('Произошла ошибка!'))
  },
  logout: async () => {
    localStorage.removeItem('token')
  },
  hasJwt: () => {
    return !!localStorage.getItem('token')
  },
  getToken: () => {
    return localStorage.getItem('token')
  },
  saveToken: (token) => {
    localStorage.setItem('token', token)
  }
}