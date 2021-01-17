import { expect } from 'chai'
import { shallowMount } from '@vue/test-utils'
import HelloWorld from '@/components/HelloWorld.vue'

describe('HelloWorld.vue', () => {
  it('renders props.msg when passed', () => {
    const msg = 'new message'
    const wrapper = shallowMount(HelloWorld, {
      propsData: { msg }
    })
    expect(wrapper.text()).to.include(msg)
  })
})
const add = require('../index');
describe('測試add函數', () => {
    it('測試5+5預期10', () => {
        if (add(5, 5) !== 10) {
            throw new Error("兩數相加結果不為兩數和");
        }
    });
});
