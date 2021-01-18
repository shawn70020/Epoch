const hi = (a,b) => {
 return a/b;
}
test('你好 我是function單元測試', () => {
  expect(hi(9,3)).toBe(3)
})

test('你好 我是檢查string單元測試',()=>{
  //搭配正規表達式
  expect('Happy new year.').toMatch(/new/)
})


test('你好 我是檢查object單元測試', () => {
  let peopleA = {
      name: 'GQSM'
  }
  peopleA.age = 25

  //測試字串
  expect(peopleA.name).toBe('GQSM')
  //測試物件
  expect(peopleA).toEqual({ name: 'GQSM', age: 25 })
})

test('你好 我是檢查number單元測試', () => {
  //整數可以使用 toBe 或 toEqual 斷言
  expect(5).toBe(5)
  expect(5).toEqual(5)

  //測試輸出值是否大於期望值 >
  expect(5).toBeGreaterThan(4)

  //測試輸出值是否大於等於期望值 >=
  expect(5).toBeGreaterThanOrEqual(5)

  //測試輸出值是否小於期望值 <
  expect(5).toBeLessThan(6)

  //測試輸出值是否小於等於期望值 <=
  expect(5).toBeLessThanOrEqual(5)
})

test('你好 我是檢查float單元測試', () => {
  //會忽略些微的誤差
  expect(0.1 + 0.2).toBeCloseTo(0.3)
  //需完全相等 下面這個不會過
  // expect(0.1 + 0.2).toBe(0.3)
})

test('你好 我是檢查array單元測試',()=>{
  let arrA = ['A','B','C']

  //檢查陣列內是否含有某值
  expect(arrA).toContain('B')
  
  //搭配迴圈檢查每個位置都不等於空
  for(let i in arrA){
      expect(arrA[i]).not.toBe('')
  }
})


test('你好 我是檢查 特殊值 單元測試',()=>{
  //期望值為 true
  expect(true).toBeTruthy()
  
  //期望值為 false
  expect(false).toBeFalsy()

  //期望值為 null
  expect(null).toBeNull()

  //期望值為 undefined
  expect(undefined).toBeUndefined()

  //期望值為 undefined 之外的值
  expect(null).toBeDefined()
})
