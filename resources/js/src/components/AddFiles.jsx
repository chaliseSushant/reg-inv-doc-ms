import React from "react";

const AddFiles = () => {
  return (
    <>
      <Space
        key={1}
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
          name="file[]"
        >
          <Input
            type="file"
            onChange={(e) => setFileList([...fileList, e.target.files[0]])}
          />
        </Form.Item>

        <Form.Item name="file_name[]" label="File Name">
          <Input />
        </Form.Item>
      </Space>
    </>
  );
};

export default AddFiles;
