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
import { useAddFileMutation } from "../../services/fileApi";
import { useEffect } from "react";
import { useGetRegistrationDocumentQuery } from "../../services/registrationApi";

const AddFile = ({ showDrawer, handleClick, document_id }) => {
  const [file, setFile] = useState("");
  const [addFile, { data, isSuccess }] = useAddFileMutation();
  const formRef = React.createRef();
  const onFinish = async (value) => {
    const formData = new FormData();
    formData.append("document_id", document_id);
    formData.append("attachments[]", file);
    formData.append("files_name[]", value.file_name);
    await addFile(formData);
    if (isSuccess) {
      message.success(data.success);
    }
    console.log(file);
  };

  useEffect(() => {
    if (isSuccess) {
      message.success(data.success);
      formRef.current.resetFields();
      handleClick();
    }
  }, [data]);
  return (
    <>
      <Drawer
        title="Add New File"
        width={500}
        visible={showDrawer}
        onClose={handleClick}
      >
        <Form layout="vertical"  ref={formRef} onFinish={onFinish}>
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
            <Col span={24}>
              <Form.Item
                name="file_name"
                label="File Name"
                rules={[{ required: true, message: "Please enter file name" }]}
              >
                <Input />
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

export default AddFile;
