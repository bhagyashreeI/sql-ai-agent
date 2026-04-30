import { useState } from "react";
import axios from "axios";

export default function SqlAgent() {
    const [prompt, setPrompt] = useState("");
    const [result, setResult] = useState(null);

    const generate = async () => {
        const res = await axios.post("/generate-query", {
            prompt,
        });

        setResult(res.data);
    };

    return (
        <div className="p-10">
            <h1 className="text-3xl font-bold mb-6">
                Laravel SQL AI Agent
            </h1>

            <textarea
                className="border w-full p-4 rounded"
                rows="5"
                value={prompt}
                onChange={(e) => setPrompt(e.target.value)}
            />

            <button
                onClick={generate}
                className="mt-4 bg-black text-white px-5 py-2 rounded"
            >
                Generate
            </button>

            {result && (
                <pre className="mt-6 bg-gray-100 p-5 rounded">
                    {JSON.stringify(result, null, 2)}
                </pre>
            )}
        </div>
    );
}