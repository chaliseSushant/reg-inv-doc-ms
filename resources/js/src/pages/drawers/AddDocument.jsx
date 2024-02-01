import React, { useState, useEffect } from "react";
import {
  Drawer,
  Form,
  Select,
  Col,
  Row,
  Input,
  Space,
  Radio,
  Button,
  message,
} from "antd";
import { useAddDocumentMutation } from "../../services/documentApi";
import { MinusCircleOutlined, PlusOutlined } from "@ant-design/icons";
import { useNavigate } from "react-router";

const AddDocument = ({ showDrawer, handleClick }) => {
  const { TextArea } = Input;
  const urgency = [
    { label: "None", value: "none",key:"none_urgency" },
    { label: "Important", value: "important" },
    { label: "Very Important", value: "very_important" },
    { label: "Urgent", value: "urgent" },
  ];
  const secrecy = [
    { label: "None", value: "none" },
    { label: "Confidential", value: "confidential" },
    { label: "Top Secret", value: "top_secret" },
  ];
  const navigate = useNavigate();
  const [fileList, setFileList] = useState([]);

  const [addDocument, { data: documentData, isSuccess }] =
    useAddDocumentMutation();
  const formRef = React.createRef();
  const onFinish = async (document) => {
    let formData = new FormData();
    fileList.forEach((file) => {
      formData.append("attachments[]", file);
    });

    for (const [key, value] of Object.entries(document)) {
      if (key === "documents") {
        value.forEach((element) => {
          formData.append("files_name[]", element.file_name);
        });
      }
    }
    for (const [key, value] of Object.entries(document)) {
      if (value !== undefined && key !== "documents")
        formData.append(key, value);
    }
    // for (var pair of formData.entries()) {
    //   console.log(pair[0] + ", " + pair[1]);
    // }
    await addDocument(formData);
  };

  useEffect(() => {
    if (isSuccess) {
      message.success(documentData.success);
      navigate(`/document/${documentData.document.id}`);
    }
  }, [documentData]);

  return (
    <Drawer
      title="Add New Document"
      width={700}
      visible={showDrawer}
      onClose={handleClick}
    >
      <Form
        layout="vertical"
        ref={formRef}
        onFinish={onFinish}
        encType="multipart/form-data"
      >
        <Form.Item name="id" hidden>
          <Input />
        </Form.Item>
        <Row gutter={16}>
          <Col span={24}>
            <Form.Item
              name="document_title"
              label="Document Title"
              rules={[
                { required: true, message: "Please enter document title" },
              ]}
            >
              <Input placeholder="Please enter document title" />
            </Form.Item>
          </Col>
        </Row>
        <Row gutter={16}>
          <Col span={24}>
            <Form.Item
              name="document_number"
              label="Document Number"
              rules={[
                { required: true, message: "Please enter document number" },
              ]}
            >
              <Input placeholder="Please enter document number" />
            </Form.Item>
          </Col>
        </Row>
        <Row gutter={16}>
          <Col span={24}>
            <Form.Item name="urgency" label="Urgency" initialValue="none">
              <Radio.Group options={urgency} optionType="button"></Radio.Group>
            </Form.Item>
          </Col>
        </Row>
        <Row gutter={16}>
          <Col span={24}>
            <Form.Item name="secrecy" label="Secrecy" initialValue="none">
              <Radio.Group options={secrecy} optionType="button"></Radio.Group>
            </Form.Item>
          </Col>
        </Row>
        <Row gutter={16}>
          <Col span={24}>
            <Form.Item
              name="document_remarks"
              label="Remarks"
              rules={[{ required: true, message: "Please enter remarks" }]}
            >
              <TextArea placeholder="Please enter remarks" rows={3}></TextArea>
            </Form.Item>
          </Col>
        </Row>
        <Form.List name="documents">
          {(fields, { add, remove }) => (
            <>
              <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
                <Col span={24}>
                  {fields.map(({ key, name }) => (
                    <Space
                      key={key}
                      style={{
                        display: "flex",
                        marginBottom: 8,
                      }}
                      align="baseline"
                    >
                      <Form.Item
                        label="Document"
                        rules={[
                          {
                            required: true,
                            message: "Please upload at least one document",
                          },
                        ]}
                        name={[name, "file"]}
                      >
                        <Input
                          type="file"
                          onChange={(e) =>
                            setFileList([...fileList, e.target.files[0]])
                          }
                        />
                      </Form.Item>

                      <Form.Item name={[name, "file_name"]} label="File Name">
                        <Input />
                      </Form.Item>

                      <MinusCircleOutlined
                        className="dynamic-delete-button"
                        onClick={() => remove(name)}
                      />
                    </Space>
                  ))}
                </Col>
              </Row>
              <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
                <Col span={24}>
                  <Form.Item>
                    <Button
                      type="dashed"
                      onClick={() => add()}
                      block
                      icon={<PlusOutlined />}
                    >
                      Add field
                    </Button>
                  </Form.Item>
                </Col>
              </Row>
            </>
          )}
        </Form.List>
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
  );
};

export default AddDocument;
