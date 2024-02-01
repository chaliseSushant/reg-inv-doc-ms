import { Drawer, Form, Select, Col, Row, Input, Space, Button } from "antd";
import { useForm } from "antd/lib/form/Form";
import React from "react";
import {
  useAddDistrictMutation,
  useUpdateDistrictMutation,
} from "../../services/districtApi";
import { useGetProvincesQuery } from "../../services/provinceApi";

const { Option } = Select;
const NewDistrict = ({ showDrawer, handleClick, districtData }) => {
  const [addDistrict] = useAddDistrictMutation();
  const { data: provinceList, isSuccess } = useGetProvincesQuery();
  const  [updateDistrict]  = useUpdateDistrictMutation();
  const onFinish = async (district) => {

    if (districtData !== null) {
      await updateDistrict(district);
    } else {
      await addDistrict(district);
    }
  };
  const [form] = useForm();
  if (districtData !== null) {
    form.setFieldsValue({
      id: districtData.id,
      name: districtData.name,
      identifier: districtData.identifier,
      province_id: districtData.province_id,
    });
  } else form.resetFields();

  const formRef = React.createRef();
  return (
    <>
      <Drawer
        title="Add New District"
        width={500}
        visible={showDrawer}
        onClose={handleClick}
      >
        <Form layout="vertical" form={form} ref={formRef} onFinish={onFinish}>
          <Form.Item name="id" hidden>
            <Input />
          </Form.Item>
          <Row gutter={16}>
            <Col span={24}>
              <Form.Item
                name="identifier"
                label="Identifier"
                rules={[{ required: true, message: "Please enter identifier" }]}
              >
                <Input placeholder="Please enter identifier" />
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={16}>
            <Col span={24}>
              <Form.Item
                name="province_id"
                label="Province"
                rules={[{ required: true, message: "Please Select Province" }]}
              >
                <Select placeholder="Select Province">
                  {isSuccess &&
                    provinceList.map((item) => {
                      return (
                        <Option key={item.id} value={item.id}>
                          {item.name}
                        </Option>
                      );
                    })}
                </Select>
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={16}>
            <Col span={24}>
              <Form.Item
                name="name"
                label="Name"
                rules={[
                  { required: true, message: "Please enter district name" },
                ]}
              >
                <Input placeholder="Please enter district name" />
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={16}>
            <Col span={24}>
              <Space>
                <Button type="primary" htmlType="submit">
                  Submit
                </Button>
                <Button onClick={handleClick}>Cancel</Button>
              </Space>
            </Col>
          </Row>
        </Form>
      </Drawer>
    </>
  );
};

export default NewDistrict;
