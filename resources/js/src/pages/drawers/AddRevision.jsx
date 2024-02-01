import React, { useState } from "react";
import {
  Drawer,
  Form,
  Select,
  Col,
  Row,
  Input,
  Space,
  Button,
  message,
} from "antd";
import { useAddRevisionMutation } from "../../services/fileApi";
import { useEffect } from "react";

const AddRevision = ({ showDrawer, handleClick, file_id }) => {
  const [file, setFile] = useState("");
  const [addRevision, { data, isSuccess }] = useAddRevisionMutation();
  const formRef = React.createRef();
  const onFinish = async (value) => {
    const formData = new FormData();
    formData.append("file_id", file_id);
    formData.append("attachment", file);
    await addRevision(formData);
  };

  useEffect(() => {
    if (isSuccess) {
      message.success(data.success);
      handleClick();
    }
  }, [data]);
  return (
    <>
      <Drawer
        title="Add New Revision"
        width={500}
        visible={showDrawer}
        onClose={handleClick}
      >
        <Form layout="vertical" ref={formRef} onFinish={onFinish}>
          <Row gutter={16}>
            <Col span={24}>
              <Form.Item
                name="file"
                label="File"
                rules={[{ required: true, message: "Please select file" }]}
              >
                <Input
                  type="file"
                  onChange={(e) => setFile(e.target.files[0])}
                  placeholder="Please select file"
                />
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={16}>
            <Col span={24} offset={15}>
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

export default AddRevision;
